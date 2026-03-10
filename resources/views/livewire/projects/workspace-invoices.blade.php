<div class="">

    <div class="p-5 bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700">

        <div class="flex justify-between items-center mb-4">
            <flux:heading size="md">Invoices</flux:heading>

            <flux:button size="sm" variant="ghost" icon="plus"
                wire:click="$dispatchTo('invoices.invoice-form-modal', 'open-create-invoice', { projectId: {{ $project->id }}, clientId: {{ $project->client_id }} })">
                Create
            </flux:button>
        </div>

        {{-- Scrollable container --}}
        <div
            class="max-h-64 overflow-y-auto pr-1 space-y-2 scrollbar-thin scrollbar-thumb-neutral-300 dark:scrollbar-thumb-neutral-600">

            @forelse($invoices as $invoice)
<div x-data="{ open: false }" class="relative group flex items-start sm:items-center justify-between p-4 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900/40 hover:bg-neutral-100 dark:hover:bg-neutral-800/60 transition gap-4 sm:gap-0">

    {{-- LEFT CONTENT --}}
    <div class="flex flex-col gap-1 sm:gap-1.5 min-w-0">

        <div class="flex items-center flex-wrap sm:flex-nowrap gap-2">
            <span class="text-sm font-semibold text-neutral-800 dark:text-neutral-200 whitespace-nowrap">
                {{ $invoice->invoice_number }}
            </span>

            <x-badges.invoice-status :invoice_status="$invoice->invoice_status" :due_date="$invoice->due_date" />
        </div>

        <span class="text-xs text-neutral-500 whitespace-nowrap">
            Due {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}
        </span>

    </div>


    {{-- RIGHT SIDE --}}
    <div class="flex items-center gap-2 sm:gap-3 shrink-0">

        <span class="text-sm font-semibold text-neutral-800 dark:text-neutral-100 whitespace-nowrap">
            {{ $invoice->currency }} {{ number_format($invoice->total, 2) }}
        </span>

        {{-- MOBILE MENU --}}
        <button @click="open = !open" class="sm:hidden flex items-center justify-center size-8 rounded-md text-neutral-500 hover:bg-neutral-200 dark:hover:bg-neutral-700 transition shrink-0">
            <flux:icon.ellipsis-horizontal class="size-4" />
        </button>

    </div>


    {{-- MOBILE ACTION MENU --}}
    <div x-show="open" @click.outside="open=false" x-transition class="sm:hidden absolute right-4 top-14 z-20 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-lg p-1 min-w-[120px]">
        <x-actions.invoice-actions :row="$invoice" />
    </div>


    {{-- DESKTOP HOVER OVERLAY --}}
    <div class="hidden sm:flex absolute inset-y-0 right-0 items-center pr-3 w-40 bg-gradient-to-l from-white/90 via-white/70 to-transparent dark:from-neutral-900/90 dark:via-neutral-900/70 backdrop-blur-md rounded-r-lg opacity-0 group-hover:opacity-100 transition-all duration-300 ease-[cubic-bezier(.16,1,.3,1)] pointer-events-none">
        <div class="pointer-events-auto flex items-center gap-1 translate-x-6 group-hover:translate-x-0 opacity-0 group-hover:opacity-100 transition-all duration-300 ease-[cubic-bezier(.16,1,.3,1)]">
            <x-actions.invoice-actions :row="$invoice" />
        </div>
    </div>

</div>











            @empty
                <div
                    class="border-2 border-dashed border-neutral-200 dark:border-neutral-700 rounded-lg p-6 text-center text-neutral-500 text-sm">
                    No invoices yet
                </div>
            @endforelse

        </div>
    </div>

</div>
