<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\TimeLog;
use App\Models\Invoice;
use App\Models\InvoiceSetting;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TaskManager extends Component
{
    public Project $project;

    public $newTaskVisible = false;
    public $newTaskTitle = '';
    public $newTaskDesc = '';

    // New Variables  for Edit
    public $editingTaskId = null;
    public $editTaskTitle = '';
    public $editTaskDesc = '';
    public $editTaskVisible;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function startTimer($taskId)
    {
        $userId = auth()->id();

        // 1. Stop any running timers for this user
        $runningTimers = TimeLog::where('user_id', $userId)
            ->whereNull('end_time')
            ->get();

        foreach ($runningTimers as $timer) {
            $endTime = now();
            $timer->update([
                'end_time' => $endTime,
                'duration_seconds' => $endTime->diffInSeconds($timer->start_time),
            ]);
        }

        // 2. Start new timer
        TimeLog::create([
            'user_id' => $userId,
            'project_id' => $this->project->id,
            'task_id' => $taskId,
            'start_time' => now(),
            'is_billed' => false,
        ]);

        session()->flash('success', 'Timer started!');
    }

    public function stopTimer($taskId)
    {
        $timer = TimeLog::where('user_id', auth()->id())
            ->where('task_id', $taskId)
            ->whereNull('end_time')
            ->first();

        if ($timer) {
            $endTime = now();
            $timer->update([
                'end_time' => $endTime,
                'duration_seconds' => $endTime->diffInSeconds($timer->start_time),
            ]);
            session()->flash('success', 'Timer stopped and logged!');
        }
    }

    public function billTimeLogs()
    {
        $unbilledLogs = TimeLog::where('project_id', $this->project->id)
            ->where('is_billed', false)
            ->whereNotNull('end_time')
            ->with('task')
            ->get();

        if ($unbilledLogs->isEmpty()) {
            session()->flash('error', 'No unbilled time logs found to invoice.');
            return;
        }

        // Check invoice limits
        if (auth()->user()->hasReachedInvoiceLimit()) {
            session()->flash('error', 'Limit Reached: You have reached the invoice limit for your current plan. Please upgrade.');
            return;
        }

        try {
            $invoice = DB::transaction(function () use ($unbilledLogs) {
                $user = auth()->user();
                $settings = InvoiceSetting::where('user_id', $user->id)->firstOrFail();

                // Lock the settings row
                $settings = InvoiceSetting::where('id', $settings->id)->lockForUpdate()->first();

                // Group logs by task to create summary invoice items
                $itemsData = [];
                $subtotal = 0;

                $hourlyRate = $this->project->hourly_rate;

                foreach ($unbilledLogs as $log) {
                    $taskTitle = $log->task ? $log->task->title : 'General Tasks';
                    $hours = $log->duration_seconds / 3600;
                    $lineTotal = round($hours * $hourlyRate, 2);

                    $desc = sprintf(
                        "Time Logged: %s (%s hours @ %s%s/hr)",
                        $taskTitle,
                        number_format($hours, 2),
                        $this->project->currency->symbol ?? '$',
                        number_format($hourlyRate, 2)
                    );

                    $itemsData[] = [
                        'description' => $desc,
                        'quantity' => round($hours, 2),
                        'unit_price' => $hourlyRate,
                        'line_total' => $lineTotal,
                    ];

                    $subtotal += $lineTotal;
                }

                // Apply tax rate from settings
                $taxRate = $settings->default_tax_rate ?? 0;
                $taxTotal = round(($subtotal * $taxRate) / 100, 2);
                $total = $subtotal + $taxTotal;

                // Generate invoice number
                $invoiceNumber = sprintf('%s-%05d', $settings->prefix, $settings->next_number);

                $companySnapshot = [
                    'company_name' => $settings->company_name,
                    'company_email' => $settings->company_email,
                    'company_phone' => $settings->company_phone,
                    'company_website' => $settings->company_website,
                    'tax_id' => $settings->tax_id,
                    'payment_methods' => $settings->payment_methods,
                    'bank_details' => $settings->bank_details,
                    'company_address' => $settings->company_address,
                ];

                $client = $this->project->client;
                $clientSnapshot = [
                    'client_name' => $client->client_name,
                    'client_email' => $client->client_email,
                    'company_name' => $client->company_name,
                    'company_email'   => $client->company_email,
                    'company_phone'   => $client->company_phone,
                    'company_website' => $client->company_website,
                ];

                // Create Invoice
                $invoice = Invoice::create([
                    'user_id'        => $user->id,
                    'client_id'      => $client->id,
                    'project_id'     => $this->project->id,
                    'uuid'           => (string) Str::uuid(),
                    'invoice_number' => $invoiceNumber,
                    'type'           => 'invoice',
                    'invoice_status' => 'draft',
                    'public_token'   => Str::random(64),
                    'issue_date'     => now()->format('Y-m-d'),
                    'due_date'       => now()->addDays($settings->default_due_days ?? 14)->format('Y-m-d'),
                    'bill_currency_id' => $this->project->currency_id,
                    'subtotal'       => $subtotal,
                    'tax_total'      => $taxTotal,
                    'discount_total' => 0,
                    'shipping_total' => 0,
                    'adjustment_total' => 0,
                    'total'          => $total,
                    'paid_total'     => 0,
                    'balance_due'    => $total,
                    'is_tax_inclusive' => (bool) $settings->default_tax_inclusive,
                    'notes'          => $settings->default_notes,
                    'terms'          => $settings->default_terms,
                    'payment_terms'  => $settings->default_payment_terms,
                    'due_days'       => $settings->default_due_days,
                    'billing_address' => $client->billing_address,
                    'company_snapshot' => $companySnapshot,
                    'client_snapshot' => $clientSnapshot,
                    'base_currency'  => $settings->default_currency_id ?? null,
                    'metadata'       => [
                        'tax_rate' => $taxRate,
                    ],
                    'default_footer' => $settings->default_footer,
                ]);

                // Create Invoice Items
                foreach ($itemsData as $index => $item) {
                    $invoice->items()->create([
                        'position' => $index + 1,
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'line_total' => $item['line_total'],
                        'invoice_id' => $invoice->id,
                    ]);
                }

                // Increment invoice number in settings
                $settings->increment('next_number');

                // Link time logs to invoice and mark as billed
                foreach ($unbilledLogs as $log) {
                    $log->update([
                        'is_billed' => true,
                        'invoice_id' => $invoice->id,
                    ]);
                }

                return $invoice;
            });

            // Dispatch refresh events
            $this->dispatch('refreshDatatable');
            $this->dispatch('refresh-invoices');
            session()->flash('success', "Success: Draft Invoice {$invoice->invoice_number} created with billable hours!");
        } catch (\Exception $e) {
            Log::error('Time Billing Error: ' . $e->getMessage());
            session()->flash('error', 'Error billing time logs: ' . $e->getMessage());
        }
    }

    public function toggleVisibility($taskId)
    {
        $task = $this->project->tasks()->findOrFail($taskId);

        $task->update(['is_visible_to_client' => !$task->is_visible_to_client]);
        // dd($this->is_visible_to_client);
    }

    public function addTask()
    {
        $this->validate([
            'newTaskTitle' => 'required|string|max:255',
            'newTaskDesc' => 'nullable|string|max:255',
        ]);

        // New task position finding with last task + 1
        $lastPosition = $this->project->tasks()->max('position') ?? 0;

        $this->project->tasks()->create([
            'project_id' => $this->project->id,
            'title' => strtolower($this->newTaskTitle),
            'description' => strtolower($this->newTaskDesc),
            'is_visible_to_client' => $this->newTaskVisible,
            'position' => $lastPosition + 1,
            'is_completed' => false,
        ]);

        $this->reset(['newTaskTitle', 'newTaskDesc']);
        session()->flash('success', 'Task added successfully!');
    }

    public function toggleTask($taskId)
    {
        $task = $this->project->tasks()->findOrFail($taskId);
        $task->update([
            'is_completed' => ! $task->is_completed,
        ]);
    }

    // lodas data and opens the modal
    public function editTask($taskId)
    {
        $task = $this->project->tasks()->findOrFail($taskId);

        $this->editingTaskId = $task->id;
        $this->editTaskTitle = $task->title;
        $this->editTaskDesc = $task->description;
        $this->editTaskVisible = $task->is_visible_to_client;
        // dd($this->editTaskVisible);

        // Flux ka tarika backend se modal kholne ka
        $this->modal('edit-task-modal')->show();
    }

    // 2. saves data and closes the modal
    public function updateTask()
    {
        $this->validate([
            'editTaskTitle' => 'required|string|max:255',
            'editTaskDesc' => 'nullable|string|max:255',
        ]);

        if ($this->editingTaskId) {
            $task = $this->project->tasks()->findOrFail($this->editingTaskId);
            $task->update([
                'title' => strtolower($this->editTaskTitle),
                'description' => strtolower($this->editTaskDesc),
                'is_visible_to_client' => $this->editTaskVisible,
            ]);

            $this->modal('edit-task-modal')->close();
            $this->reset(['editingTaskId', 'editTaskTitle', 'editTaskDesc', 'editTaskVisible']);
            session()->flash('success', 'Task updated successfully!');
        }
    }

    public function deleteTask($taskId)
    {
        $this->project->tasks()->findOrFail($taskId)->delete();
        session()->flash('success', 'Task removed.');
    }

    public function render()
    {
        $runningTimer = TimeLog::where('user_id', auth()->id())
            ->where('project_id', $this->project->id)
            ->whereNull('end_time')
            ->first();

        return view('livewire.projects.task-manager', [
            'tasks' => $this->project->tasks()->orderBy('position')->get(),
            'runningTimer' => $runningTimer,
        ]);
    }
}
