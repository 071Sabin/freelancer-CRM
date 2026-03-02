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

<div class="min-h-screen pt-10 text-neutral-900 dark:text-neutral-100">

    <div
        class="max-w-3xl mx-auto p-6 space-y-8 bg-neutral-50/70 dark:bg-neutral-800 rounded border border-neutral-200 dark:border-neutral-700 rounded-lg">
        <h2 class="text-sm font-semibold uppercase text-neutral-700 dark:text-neutral-300">
            Client Secure Project Portal
        </h2>
        <x-hr-divider />
        {{-- Header --}}
        <div class="flex items-start justify-between">

            <div>
                <h1 class="text-xl sm:text-2xl font-semibold leading-tight">
                    {{ $project->name }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                    {{ $project->client->client_name ?? 'N/A' }}
                </p>
            </div>

            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium border {{ $currentStatus['classes'] }}">
                <span class="h-2 w-2 rounded-full bg-current"></span>
                {{ $currentStatus['label'] }}
            </div>

        </div>

        {{-- Project Meta Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-y-6 gap-x-8 text-sm">

            <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">
                    Project Value
                </p>
                <p class="mt-1 font-medium">
                    {{ $project->currency->symbol ?? '' }}
                    {{ number_format($project->value, 2) }}
                </p>
            </div>

            <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">
                    Hourly Rate
                </p>
                <p class="mt-1 font-medium">
                    {{ $project->currency->symbol ?? '' }}
                    {{ number_format($project->hourly_rate, 2) }}
                </p>
            </div>

            <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">
                    Deadline
                </p>
                <p class="mt-1 font-medium">
                    {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}
                </p>
            </div>

            <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">
                    Total Invoices
                </p>
                <p class="mt-1 font-medium">
                    {{ $project->invoices->count() ?? 0 }}
                </p>
            </div>

            <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-xs uppercase tracking-wide">
                    Created
                </p>
                <p class="mt-1 font-medium">
                    {{ $project->created_at->format('M d, Y') }}
                </p>
            </div>

        </div>
        <x-hr-divider />
        {{-- Description --}}
        @if ($project->description)
            <div class="border-t border-neutral-200 dark:border-neutral-800 pt-6">
                <p class="text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed">
                    {{ $project->description }}
                </p>
            </div>
        @endif
        <x-hr-divider />
        {{-- Invoices --}}
        <div class="border-t border-neutral-200 dark:border-neutral-800 pt-8 space-y-6">

            <h2 class="text-sm font-semibold tracking-wide uppercase text-neutral-700 dark:text-neutral-300">
                Billing
            </h2>

            @if ($project->invoices && $project->invoices->count() > 0)

                <div class="space-y-4">

                    @foreach ($project->invoices as $invoice)
                        <div
                            class="flex items-center justify-between 
                                    py-4 border-b border-neutral-200 dark:border-neutral-800">

                            <div>
                                <p class="text-sm font-medium">
                                    Invoice #{{ $invoice->invoice_number }}
                                </p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                    Due {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                </p>
                            </div>

                            <div class="flex items-center gap-5">

                                <span
                                    class="text-xs font-medium
                                    {{ $invoice->status === 'Paid'
                                        ? 'text-emerald-600 dark:text-emerald-400'
                                        : 'text-amber-600 dark:text-amber-400' }}">
                                    {{ $invoice->status }}
                                </span>

                                <x-primary-button>
                                    PDF
                                </x-primary-button>

                            </div>

                        </div>
                        <x-hr-divider />
                    @endforeach

                </div>
            @else
                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                    No invoices available.
                </p>

            @endif

        </div>

    </div>
</div>
