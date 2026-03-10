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
                <div
                    class="relative group flex items-center justify-between p-3 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900/40 hover:bg-neutral-100 dark:hover:bg-neutral-800/60 transition">

                    <div class="flex flex-col">
                        <span class="text-sm font-medium text-neutral-800 dark:text-neutral-200">
                            {{ $invoice->invoice_number }}
                        </span>

                        <span class="text-xs text-neutral-500">
                            Due {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}
                        </span>
                    </div>

                    <div class="flex items-center gap-3">
                        <x-badges.invoice-status :invoice_status="$invoice->invoice_status" :due_date="$invoice->due_date" />

                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">
                            {{ $invoice->currency }} {{ number_format($invoice->total, 2) }}
                        </span>
                    </div>


                    {{-- ACTION OVERLAY --}}
                    <div
                        class="absolute inset-y-0 right-0 flex items-center pr-3 w-40 bg-gradient-to-l from-white/90 via-white/70 to-transparent dark:from-neutral-900/90 dark:via-neutral-900/70 backdrop-blur-md rounded-r-lg opacity-0 group-hover:opacity-100 transition-all duration-300 ease-out pointer-events-none">

                        <div
                            class="pointer-events-auto flex items-center gap-1 translate-x-6 group-hover:translate-x-0 opacity-0 group-hover:opacity-100 transition-all duration-300 ease-out">

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
