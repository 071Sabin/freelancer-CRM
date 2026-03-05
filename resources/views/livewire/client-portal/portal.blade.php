@php
    $statusMap = [
        'active' => [
            'label' => 'Active',
            'classes' => 'bg-blue-50 text-blue-700 border-blue-200 
                          dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
        ],
        'in_progress' => [
            'label' => 'In Progress',
            'classes' => 'bg-blue-50 text-blue-700 border-blue-200 
                          dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
        ],
        'on_hold' => [
            'label' => 'On Hold',
            'classes' => 'bg-amber-50 text-amber-700 border-amber-200 
                          dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
        ],
        'completed' => [
            'label' => 'Completed',
            'classes' => 'bg-green-50 text-green-700 border-green-200 
                          dark:bg-green-900/30 dark:text-green-400 dark:border-green-800',
        ],
        'cancelled' => [
            'label' => 'Cancelled',
            'classes' => 'bg-rose-50 text-rose-700 border-rose-200 
                          dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800',
        ],
    ];

    $status = $project->status ?? 'in_progress';
    $currentStatus = $statusMap[$status] ?? $statusMap['in_progress'];
@endphp

<div class="min-h-screen py-12 px-4 sm:px-6 text-neutral-900 dark:text-neutral-100 bg-neutral-50/50 dark:bg-neutral-950">

    <div class="max-w-4xl mx-auto p-8 sm:p-10 space-y-8 bg-white dark:bg-neutral-900 shadow-sm border border-neutral-200 dark:border-neutral-800 rounded-2xl">
        
        <h2 class="text-xs font-bold tracking-widest uppercase text-neutral-400 dark:text-neutral-500">
            Client Secure Project Portal
        </h2>
        
        <x-hr-divider />
        
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold leading-tight tracking-tight text-neutral-900 dark:text-white">
                    {{ $project->name }}
                </h1>
                <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400 mt-2">
                    Prepared for <span class="text-neutral-700 dark:text-neutral-300">{{ $project->client->client_name ?? 'N/A' }}</span>
                </p>
            </div>

            <div class="inline-flex w-fit items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wide border {{ $currentStatus['classes'] }}">
                <span class="h-2 w-2 rounded-full bg-current"></span>
                {{ $currentStatus['label'] }}
            </div>
        </div>

        {{-- Project Meta Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-y-6 gap-x-6 text-sm pt-2">
            <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-[11px] font-semibold uppercase tracking-wider">Project Value</p>
                <p class="mt-1.5 font-semibold text-neutral-900 dark:text-neutral-100 text-base">
                    {{ $project->currency->symbol ?? '' }}{{ number_format($project->value, 2) }}
                </p>
            </div>
            <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-[11px] font-semibold uppercase tracking-wider">Hourly Rate</p>
                <p class="mt-1.5 font-semibold text-neutral-900 dark:text-neutral-100 text-base">
                    {{ $project->currency->symbol ?? '' }}{{ number_format($project->hourly_rate, 2) }}
                </p>
            </div>
            <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-[11px] font-semibold uppercase tracking-wider">Deadline</p>
                <p class="mt-1.5 font-medium text-neutral-800 dark:text-neutral-200">
                    {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}
                </p>
            </div>
            <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-[11px] font-semibold uppercase tracking-wider">Total Invoices</p>
                <p class="mt-1.5 font-medium text-neutral-800 dark:text-neutral-200">
                    {{ $project->invoices->count() ?? 0 }}
                </p>
            </div>
            <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-[11px] font-semibold uppercase tracking-wider">Created</p>
                <p class="mt-1.5 font-medium text-neutral-800 dark:text-neutral-200">
                    {{ $project->created_at->format('M d, Y') }}
                </p>
            </div>
        </div>

        <x-hr-divider />

        {{-- NEW: Progress Bar --}}
        <div class="space-y-3">
            <div class="flex justify-between items-end">
                <h2 class="text-sm font-semibold tracking-wide uppercase text-neutral-700 dark:text-neutral-300">
                    Project Progress
                </h2>
                <span class="text-sm font-bold text-neutral-900 dark:text-white">45%</span>
            </div>
            <div class="w-full bg-neutral-100 dark:bg-neutral-800 rounded-full h-2.5 overflow-hidden">
                <div class="bg-neutral-900 dark:bg-neutral-100 h-full rounded-full transition-all duration-1000 ease-out" style="width: 45%"></div>
            </div>
            <p class="text-xs text-neutral-500 dark:text-neutral-400 font-medium">Currently executing planned milestones.</p>
        </div>

        <x-hr-divider />

        {{-- Description Box (Upgraded) --}}
        @if ($project->description)
            <div class="space-y-4">
                <h2 class="text-sm font-semibold tracking-wide uppercase text-neutral-700 dark:text-neutral-300">
                    Project Scope & Details
                </h2>
                
                <div class="p-6 rounded-xl bg-neutral-50 dark:bg-neutral-800/40 border border-neutral-100 dark:border-neutral-700/50">
                    <p class="text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed whitespace-pre-line">
                        {{ $project->description }}
                    </p>
                </div>
            </div>
            <x-hr-divider />
        @endif

        {{-- Invoices --}}
        <div class="space-y-6 pt-2">
            <h2 class="text-sm font-semibold tracking-wide uppercase text-neutral-700 dark:text-neutral-300">
                Billing & Invoices
            </h2>

            @if ($project->invoices && $project->invoices->count() > 0)
                <div class="space-y-3">
                    @foreach ($project->invoices as $invoice)
                        <div class="flex items-center justify-between p-4 rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 hover:border-neutral-300 dark:hover:border-neutral-700 transition-colors">
                            <div>
                                <p class="text-sm font-semibold text-neutral-900 dark:text-neutral-100">
                                    Invoice #{{ $invoice->invoice_number }}
                                </p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                    Due {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                </p>
                            </div>

                            <div class="flex items-center gap-5">
                                <span class="text-xs font-bold uppercase tracking-wider px-2 py-1 rounded-md bg-neutral-50 dark:bg-neutral-800
                                    {{ $invoice->invoice_status === 'Paid'
                                        ? 'text-emerald-600 dark:text-emerald-400'
                                        : 'text-amber-600 dark:text-amber-400' }}">
                                    {{ $invoice->invoice_status }}
                                </span>

                                <x-primary-button class="text-xs px-4 py-1.5">
                                    View PDF
                                </x-primary-button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-10 px-4 border-2 border-dashed border-neutral-200 dark:border-neutral-700/60 rounded-xl bg-neutral-50/50 dark:bg-neutral-800/20">
                    <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                        No invoices generated yet.
                    </p>
                </div>
            @endif
        </div>

    </div>
</div>