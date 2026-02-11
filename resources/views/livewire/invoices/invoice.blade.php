<div class="">

    <x-main-heading title="Invoices" subtitle="Create, send, and track invoices with clear payment status and totals." />

    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif

    {{-- main cards for details --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

        <x-dashboard-card heading="Total Invoices" value="0" dataOverTime="All time"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v7.5m2.25-6.466a9.016 9.016 0 0 0-3.461-.203c-.536.072-.974.478-1.021 1.017a4.559 4.559 0 0 0-.018.402c0 .464.336.844.775.994l2.95 1.012c.44.15.775.53.775.994 0 .136-.006.27-.018.402-.047.539-.485.945-1.021 1.017a9.077 9.077 0 0 1-3.461-.203M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>'
            dataColor="text-neutral-400 dark:text-neutral-500" />

        <x-dashboard-card heading="Paid Invoices" value="0" dataOverTime="Successfully paid"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>'
            dataColor="text-emerald-600 dark:text-emerald-500" />

        <x-dashboard-card heading="Outstanding" value="$0.00" dataOverTime="Awaiting payment"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-3h6"/></svg>'
            dataColor="text-amber-600 dark:text-amber-500" />

        <x-dashboard-card heading="Overdue" value="0" dataOverTime="Past due date"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>'
            dataColor="text-red-600 dark:text-red-500" />
    </div>



    <div class="flex flex-col sm:flex-row justify-end items-center my-3 gap-4">
        <flux:modal.trigger name="create-invoice">
            <x-primary-button class="flex gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd"
                        d="M19.5 21a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3h-5.379a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H4.5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h15Zm-6.75-10.5a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V10.5Z"
                        clip-rule="evenodd" />
                </svg>
                Create invoice
            </x-primary-button>
        </flux:modal.trigger>
        <a href="{{ route('invoices.settings.general') }}" wire:navigate
            class="text-zinc-500 hover:text-zinc-900 dark:hover:text-white">
            <flux:icon.cog-6-tooth />
        </a>
    </div>

    <div>
        <flux:modal name="create-invoice" class="max-w-lg">
            <form wire:submit.prevent="create" class="space-y-6">
                <div>
                    <flux:heading size="lg">Create New Invoice</flux:heading>
                    <flux:text class="text-neutral-500">
                        Start by selecting a client. You can add items in the next step.
                    </flux:text>
                    @if ($due_date_notice)
                        <p class="mt-2 text-xs text-yellow-500 dark:text-yellow-400">
                            {{ $due_date_notice }}
                        </p>
                    @endif
                </div>

                <flux:select label="Client" wire:model="client_id" placeholder="Select client">
                    @foreach ($clients as $client)
                        <flux:select.option value="{{ $client->id }}">
                            {{ $client->client_name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select label="Project" wire:model="project_id" placeholder="Select project">
                    @foreach ($projects as $project)
                        <flux:select.option value="{{ $project->id }}">
                            {{ $project->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <div class="grid grid-cols-2 gap-4">
                    <flux:input type="date" label="Issue Date" wire:model.live="issue_date" />
                    <div>
                        <flux:input type="date" label="Due Date" wire:model.defer="due_date" />
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <x-primary-button type="submit">
                        Create & Add Items
                    </x-primary-button>
                </div>
            </form>
        </flux:modal>

    </div>

    @if ($total_invoices == 0)
        <x-empty-state title="No Invoices Yet"
            subtitle="You haven't created any invoices yet. Start by creating a new invoice to manage your billing.">
            <x-slot:icon>
                <i class="bi bi-file-text text-2xl"></i>
            </x-slot:icon>
        </x-empty-state>
    @else
        <livewire:invoices.invoice-table />
    @endif

    {{-- View Invoice Modal --}}
    <flux:modal name="view-invoice-modal" class="min-h-[600px] w-full md:min-w-[800px] !bg-white dark:!bg-neutral-800">
        <div>
            <div wire:loading wire:target="view">
                <div class="flex justify-center p-8">
                    <flux:icon.loading />
                </div>
            </div>

            <div wire:loading.remove wire:target="view">
                @if ($viewingInvoice)
                    <div class="space-y-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <flux:heading size="xl">Invoice #{{ $viewingInvoice->invoice_number }}
                                </flux:heading>
                                <flux:text>{{ $viewingInvoice->client->client_name ?? 'Unknown Client' }}</flux:text>
                            </div>
                            <div class="text-right">
                                <flux:badge size="lg"
                                    :color="$viewingInvoice->invoice_status === 'paid' ? 'green' : 'zinc'">
                                    {{ ucfirst($viewingInvoice->invoice_status) }}
                                </flux:badge>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <flux:label>Project</flux:label>
                                <div class="font-medium">{{ $viewingInvoice->project->name ?? '—' }}</div>
                            </div>
                            <div>
                                <flux:label>Total Amount</flux:label>
                                <div class="font-medium text-lg">{{ $viewingInvoice->currency }}
                                    {{ number_format($viewingInvoice->total, 2) }}</div>
                            </div>
                            <div>
                                <flux:label>Issue Date</flux:label>
                                <div>{{ \Carbon\Carbon::parse($viewingInvoice->issue_date)->format('M d, Y') }}</div>
                            </div>
                            <div>
                                <flux:label>Due Date</flux:label>
                                <div>{{ \Carbon\Carbon::parse($viewingInvoice->due_date)->format('M d, Y') }}</div>
                            </div>
                        </div>

                        {{-- Items List --}}
                        <div class="border-t border-neutral-200 dark:border-neutral-700 pt-4">
                            <flux:heading size="lg" class="mb-4">Items</flux:heading>
                            <table class="w-full text-left text-sm text-neutral-600 dark:text-neutral-400">
                                <thead class="border-b border-neutral-200 dark:border-neutral-700 font-medium">
                                    <tr>
                                        <th class="py-2">Description</th>
                                        <th class="py-2 text-right">Qty</th>
                                        <th class="py-2 text-right">Price</th>
                                        <th class="py-2 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                    @foreach ($viewingInvoice->items as $item)
                                        <tr>
                                            <td class="py-3">{{ $item->description }}</td>
                                            <td class="py-3 text-right">{{ $item->quantity }}</td>
                                            <td class="py-3 text-right">{{ number_format($item->unit_price, 2) }}</td>
                                            <td class="py-3 text-right font-medium text-neutral-900 dark:text-white">
                                                {{ number_format($item->line_total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="font-bold text-neutral-900 dark:text-white">
                                    <tr>
                                        <td colspan="3" class="py-4 text-right">Total</td>
                                        <td class="py-4 text-right">{{ $viewingInvoice->currency }}
                                            {{ number_format($viewingInvoice->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="flex justify-between pt-6">
                            <flux:button icon="arrow-down-tray" wire:click="downloadPdf({{ $viewingInvoice->id }})">
                                Download PDF
                            </flux:button>
                            <flux:button wire:click="$dispatch('close-modal', 'view-invoice-modal')">Close</flux:button>
                        </div>
                    </div>
                @else
                    <div class="text-center text-neutral-500">No invoice selected.</div>
                @endif
            </div>
        </div>
    </flux:modal>

    {{-- Edit Invoice Modal --}}
    <flux:modal name="edit-invoice-modal" class="min-h-[600px] w-full md:min-w-[900px] !bg-white dark:!bg-neutral-800">
        <div>
            <div wire:loading wire:target="edit">
                <div class="flex justify-center p-8">
                    <flux:icon.loading />
                </div>
            </div>

            <div wire:loading.remove wire:target="edit">
                @if ($editingInvoice)
                    <div class="space-y-6">
                        <flux:heading size="lg">Edit Invoice #{{ $editingInvoice->invoice_number }}
                        </flux:heading>

                        <form wire:submit.prevent="update" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <flux:input type="date" label="Issue Date"
                                    wire:model="editingInvoice.issue_date" />
                                <flux:input type="date" label="Due Date" wire:model="editingInvoice.due_date" />
                            </div>

                            {{-- Items Editor --}}
                            <div class="border-t border-neutral-200 dark:border-neutral-700 pt-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-medium text-neutral-900 dark:text-white">Items</h3>
                                    <flux:button size="sm" icon="plus" wire:click="addItem">Add Item
                                    </flux:button>
                                </div>

                                <div class="space-y-3">
                                    @foreach ($invoiceItems as $index => $item)
                                        <div class="grid grid-cols-12 gap-2 items-start"
                                            wire:key="item-{{ $index }}">
                                            <div class="col-span-5">
                                                <flux:input placeholder="Description"
                                                    wire:model.blur="invoiceItems.{{ $index }}.description" />
                                            </div>
                                            <div class="col-span-2">
                                                <flux:input type="number" placeholder="Qty" min="0"
                                                    step="0.01"
                                                    wire:model.blur="invoiceItems.{{ $index }}.quantity" />
                                            </div>
                                            <div class="col-span-2">
                                                <flux:input type="number" placeholder="Price" min="0"
                                                    step="0.01"
                                                    wire:model.blur="invoiceItems.{{ $index }}.unit_price" />
                                            </div>
                                            <div class="col-span-2 flex items-center justify-end h-10 px-3">
                                                <span class="font-medium tabular-nums">
                                                    {{ number_format($item['line_total'], 2) }}
                                                </span>
                                            </div>
                                            <div class="col-span-1 flex justify-center pt-1">
                                                <button type="button"
                                                    class="text-neutral-400 hover:text-red-500 transition-colors"
                                                    wire:click="removeItem({{ $index }})">
                                                    <flux:icon.trash class="size-4" />
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Totals --}}
                            <div class="border-t border-neutral-200 dark:border-neutral-700 pt-4 flex justify-end">
                                <div class="w-full md:w-1/3 space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-neutral-500">Subtotal</span>
                                        <span class="font-medium">{{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm items-center">
                                        <span class="text-neutral-500">Tax (%)</span>
                                        <div class="w-20">
                                            <flux:input type="number" min="0" step="0.01" size="sm"
                                                wire:model.blur="editingInvoice.tax_rate"
                                                wire:change="calculateTotals" />
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-neutral-500">Tax Amount</span>
                                        <span class="font-medium">{{ number_format($tax_total, 2) }}</span>
                                    </div>
                                    <div
                                        class="flex justify-between text-base font-bold text-neutral-900 dark:text-white pt-2 border-t border-neutral-200 dark:border-neutral-700">
                                        <span>Total</span>
                                        <span>{{ $editingInvoice->currency ?? '$' }}
                                            {{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>


                            <div
                                class="flex justify-end gap-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                                <flux:button variant="ghost"
                                    wire:click="$dispatch('close-modal', 'edit-invoice-modal')">Cancel</flux:button>
                                <flux:button type="submit" variant="primary">Save Changes</flux:button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="text-center text-neutral-500">No invoice selected.</div>
                @endif
            </div>
        </div>
    </flux:modal>

</div>
