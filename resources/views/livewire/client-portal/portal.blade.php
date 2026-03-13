<div class="min-h-screen sm:px-6 text-neutral-900 dark:text-neutral-100">

    <div
        class="w-full sm:max-w-3xl mx-auto p-8 sm:p-10 space-y-8 bg-white dark:bg-neutral-900 shadow-sm border border-neutral-200 dark:border-neutral-800 rounded-2xl">

        <h2 class="text-xs font-bold tracking-widest uppercase text-neutral-400 dark:text-neutral-500">
            Client Secure Project Portal
        </h2>

        <x-hr-divider />

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 sm:gap-4">

            <div class="min-w-0">

                {{-- Project Title --}}
                <h1
                    class="text-lg sm:text-2xl font-bold leading-tight tracking-tight text-neutral-900 dark:text-white truncate">
                    {{ $project->name }}
                </h1>

                {{-- Client + Mobile Status --}}
                <div class="mt-2 flex items-center gap-2 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">

                    <span class="flex items-center gap-1.5 text-neutral-700 dark:text-neutral-300 min-w-0">
                        <flux:icon.user class="size-4 opacity-80 shrink-0" />
                        <span class="truncate">
                            {{ $project->client->client_name ?? 'N/A' }}
                        </span>
                    </span>

                    {{-- Status --}}
                    <x-badges.project-status :project_status="$project->status" />

                </div>
            </div>


        </div>

        {{-- Project Meta Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 pt-2">

            {{-- Project Value --}}
            <div
                class="p-3 sm:p-4 rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900">
                <p
                    class="text-xs sm:text-[11px] font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                    Project Value
                </p>

                <p
                    class="mt-1 text-xs sm:text-sm lg:text-base font-semibold text-neutral-900 dark:text-neutral-100 truncate">
                    {{ $project->currency->symbol ?? '' }}{{ number_format($project->value, 2) }}
                </p>
            </div>


            {{-- Hourly Rate --}}
            <div
                class="p-3 sm:p-4 rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900">
                <p
                    class="text-xs sm:text-[11px] font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                    Rate/Hr.
                </p>

                <p
                    class="mt-1 text-xs sm:text-sm lg:text-base font-semibold text-neutral-900 dark:text-neutral-100 truncate">
                    {{ $project->currency->symbol ?? '' }}{{ number_format($project->hourly_rate, 2) }}
                </p>
            </div>


            {{-- Deadline --}}
            <div
                class="p-3 sm:p-4 rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900">
                <p
                    class="text-xs sm:text-[11px] font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                    Deadline
                </p>

                <p class="mt-1 text-xs sm:text-sm font-medium text-neutral-800 dark:text-neutral-200">
                    {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}
                </p>
            </div>


            {{-- Total Invoices --}}
            <div
                class="p-3 sm:p-4 rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900">
                <p
                    class="text-xs sm:text-[11px] font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                    Total Invoices
                </p>

                <p class="mt-1 text-xs sm:text-sm font-medium text-neutral-800 dark:text-neutral-200">
                    {{ $project->invoices->count() ?? 0 }}
                </p>
            </div>


            {{-- Created --}}
            <div
                class="p-3 sm:p-4 rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900">
                <p
                    class="text-xs sm:text-[11px] font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                    Created
                </p>

                <p class="mt-1 text-xs sm:text-sm font-medium text-neutral-800 dark:text-neutral-200">
                    {{ $project->created_at->format('M d, Y') }}
                </p>
            </div>
        </div>

        <x-hr-divider />

        {{-- NEW: Progress Bar --}}
        <div class="space-y-2.5 w-full">
            {{-- Header: Label & Metric --}}
            <div class="flex items-end justify-between">
                <h2 class="text-[11px] font-bold tracking-wider text-zinc-500 uppercase dark:text-zinc-400">
                    Project Progress
                </h2>
                <div class="flex items-baseline gap-[2px]">
                    <span
                        class="text-lg font-bold tracking-tight text-zinc-900 dark:text-white tabular-nums leading-none">
                        {{ $progressPercentage }}
                    </span>
                    <span class="text-xs font-semibold text-zinc-400 dark:text-zinc-500">%</span>
                </div>
            </div>

            {{-- Progress Track & Fill --}}
            <div class="relative w-full h-1.5 md:h-2.5 overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-800/60 ring-1 ring-inset ring-zinc-200/50 dark:ring-zinc-700/50 shadow-inner"
                role="progressbar" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"
                aria-label="Project completion status">

                {{-- Progress Indicator with Edge Lighting --}}
                <div class="absolute top-0 bottom-0 left-0 h-full rounded-full bg-zinc-900 dark:bg-zinc-100 transition-[width] duration-1000 ease-out flex justify-end overflow-hidden"
                    style="width: {{ $progressPercentage }}%">
                    {{-- Leading Edge Highlight (Premium detail) --}}
                    <div class="w-12 h-full bg-gradient-to-r from-transparent to-white/20 dark:to-black/10"></div>
                </div>
            </div>

            {{-- Contextual Footer (Semantic Feedback) --}}
            <div class="flex items-center gap-2 text-xs font-medium">
                @if ($progressPercentage == 100)
                    <flux:icon.check-circle class="size-3.5 text-emerald-500" />
                    <span class="text-emerald-600 dark:text-emerald-400">Completed</span>
                @elseif($progressPercentage > 0)
                    {{-- Pulsing indicator for active work --}}
                    <span class="relative flex size-2 items-center justify-center shrink-0">
                        <span
                            class="absolute inline-flex w-full h-full rounded-full opacity-75 bg-blue-500 animate-ping"></span>
                        <span class="relative inline-flex size-1.5 rounded-full bg-blue-600 dark:bg-blue-500"></span>
                    </span>
                    <span class="text-zinc-500 dark:text-zinc-400">Executing planned milestones</span>
                @else
                    <flux:icon.clock class="size-3.5 text-zinc-400" />
                    <span class="text-zinc-500 dark:text-zinc-400">Waiting to start</span>
                @endif
            </div>
        </div>

        {{-- NEW: Client Visible Milestones --}}
        @if ($clientTasks && $clientTasks->count() > 0)
            <x-hr-divider />

            <div class="w-full">

                {{-- Header --}}
                <h2
                    class="mb-4 sm:mb-5 text-[10px] sm:text-xs font-bold tracking-widest uppercase text-zinc-500 dark:text-zinc-400">
                    Project Journey
                </h2>

                <div class="relative">

                    {{-- Vertical Path --}}
                    <div
                        class="absolute left-3 sm:left-4 top-0 bottom-0 w-px bg-gradient-to-b from-zinc-200 via-zinc-300 to-transparent dark:from-zinc-800 dark:via-zinc-700">
                    </div>

                    <div class="space-y-3 sm:space-y-4">

                        @foreach ($clientTasks as $task)
                            <div class="flex items-start gap-3 sm:gap-4">

                                {{-- Node --}}
                                <div class="shrink-0 mt-1">

                                    @if ($task->is_completed)
                                        <div
                                            class="flex items-center justify-center w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 ring-1 ring-emerald-500/30">
                                            <flux:icon.check class="size-3 sm:size-3.5 stroke-[3]" />
                                        </div>
                                    @else
                                        <div
                                            class="flex items-center justify-center w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 ring-1 ring-blue-500/30 shadow-[0_0_0_5px_rgba(59,130,246,0.06)]">
                                            <flux:icon.clock class="size-3 sm:size-3.5 stroke-[2.5]" />
                                        </div>
                                    @endif
                                </div>

                                {{-- Card --}}
                                <div
                                    class="flex-1 min-w-0 rounded-lg border px-3 sm:px-4 py-2.5 sm:py-3 transition-colors {{ $task->is_completed ? 'bg-zinc-50 dark:bg-zinc-900/40 border-zinc-200 dark:border-zinc-800' : 'bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600' }}">
                                    <div class="flex items-center justify-between gap-2">
                                        <span
                                            class="truncate text-xs sm:text-sm font-medium {{ $task->is_completed ? 'text-zinc-400 line-through' : 'text-zinc-800 dark:text-zinc-100' }}"
                                            title="{{ $task->title }}">
                                            {{ Str::limit($task->title, 30) }}
                                        </span>

                                        <span
                                            class="shrink-0 text-[9px] sm:text-[10px] font-bold uppercase tracking-wider px-1.5 sm:px-2 py-0.5 rounded {{ $task->is_completed ? 'text-emerald-600 bg-emerald-50 dark:bg-emerald-500/10' : 'text-blue-600 bg-blue-50 dark:bg-blue-500/10' }}">
                                            {{ $task->is_completed ? 'Done' : 'Active' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        {{-- INTERNAL FINALIZATION --}}
                        @if ($hasPendingInternalTasks)
                            <div class="flex items-start gap-3 sm:gap-4">

                                {{-- Node --}}
                                <div class="shrink-0 mt-1">

                                    <div
                                        class="flex items-center justify-center w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 ring-1 ring-indigo-400/30">

                                        <svg class="size-3 sm:size-3.5 animate-spin" viewBox="0 0 24 24" fill="none">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="3" opacity="0.2" />
                                            <path d="M22 12a10 10 0 00-10-10" stroke="currentColor" stroke-width="3" />
                                        </svg>
                                    </div>
                                </div>

                                {{-- Card --}}
                                <div
                                    class="flex-1 min-w-0 rounded-lg border px-3 sm:px-4 py-3 border-indigo-200 dark:border-indigo-800 bg-indigo-50/70 dark:bg-indigo-900/20">

                                    <div class="flex items-center justify-between gap-2 mb-1">

                                        <span
                                            class="text-xs sm:text-sm font-medium text-indigo-900 dark:text-indigo-100">Final Review in Progress</span>

                                        <span
                                            class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 animate-pulse">
                                            Active
                                        </span>
                                    </div>

                                    <p
                                        class="text-[11px] sm:text-xs text-indigo-700/80 dark:text-indigo-300/80 leading-relaxed">
                                            Final touches, testing, and quality checks are being completed before the project is delivered.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <x-hr-divider />

        {{-- Description Box (Upgraded) --}}
        @if ($project->description)
            <div class="space-y-4">
                <h2 class="text-xs font-semibold tracking-wide uppercase text-neutral-700 dark:text-neutral-300">
                    Project Scope & Details
                </h2>

                <div
                    class="p-6 rounded-xl bg-neutral-50 dark:bg-neutral-800/40 border border-neutral-100 dark:border-neutral-700/50">
                    <p class="text-xs md:text-sm text-neutral-600 dark:text-neutral-300">
                        {{ $project->description }}
                    </p>
                </div>
            </div>
            <x-hr-divider />
        @endif

        {{-- Invoices --}}
        <div class="space-y-6 pt-2">
            <h2 class="text-xs font-semibold tracking-wide uppercase text-neutral-700 dark:text-neutral-300">
                Billing & Invoices
            </h2>

            @if ($project->invoices && $project->invoices->count() > 0)
                <div class="space-y-3">

                    @foreach ($project->invoices as $invoice)
                        <div
                            class="p-3 sm:p-4 rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 hover:border-neutral-300 dark:hover:border-neutral-700 transition-colors">

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                                {{-- Invoice Info --}}
                                <div class="">

                                    <p
                                        class="text-xs sm:text-sm font-semibold text-neutral-900 dark:text-neutral-100 truncate">
                                        Invoice #{{ $invoice->invoice_number }}
                                    </p>

                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                        Due {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                    </p>

                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center justify-between w-full flex-wrap">

                                    {{-- Status --}}
                                    <x-badges.invoice-status :invoice_status="$invoice->invoice_status" :due_date="$invoice->due_date" />


                                    {{-- Button --}}
                                    <x-primary-button wire:click="downloadInvoice({{ $invoice->id }})"
                                        wire:loading.attr="disabled"
                                        class="text-xs px-3 sm:px-4 py-1.5 flex items-center gap-2 whitespace-nowrap">

                                        <svg wire:loading wire:target="downloadInvoice({{ $invoice->id }})"
                                            class="animate-spin h-3 w-3 text-white" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">

                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>

                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>

                                        </svg>

                                        <span wire:loading.remove wire:target="downloadInvoice({{ $invoice->id }})">
                                            PDF
                                        </span>

                                        <span wire:loading wire:target="downloadInvoice({{ $invoice->id }})">
                                            <svg class="animate-spin h-4 w-4 text-current"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                                                </path>
                                            </svg>
                                        </span>
                                    </x-primary-button>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>
            @else
                <div
                    class="flex flex-col items-center justify-center py-10 px-4 border-2 border-dashed border-neutral-200 dark:border-neutral-700/60 rounded-xl bg-neutral-50/50 dark:bg-neutral-800/20">
                    <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                        No invoices generated yet.
                    </p>
                </div>
            @endif
        </div>

    </div>

</div>
