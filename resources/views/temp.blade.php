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


                    <x-badges.invoice-status :invoice_status="$invoice->invoice_status" :due_date="$invoice->due_date" />

                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">
                        {{ $invoice->currency }} {{ number_format($invoice->total, 2) }}
                    </span>


                    {{-- ACTION OVERLAY --}}
                    <div
                        class="absolute inset-y-0 right-0 flex items-center pr-3 w-40 bg-gradient-to-l from-white/90 via-white/70 to-transparent dark:from-neutral-900/90 dark:via-neutral-900/70 backdrop-blur-md rounded-r-lg opacity-0 group-hover:opacity-100 transition-all duration-300 ease-out pointer-events-none">

                        <div
                            class="pointer-events-auto cursor-pointer flex items-center gap-1 translate-x-6 group-hover:translate-x-0 opacity-0 group-hover:opacity-100 transition-all duration-300 ease-out">

                            <x-actions.invoice-actions :row="$invoice" />

                        </div>
                    </div>

                </div>