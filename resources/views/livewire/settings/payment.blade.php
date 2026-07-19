<div>
    <x-main-heading title="Payment Settings" subtitle="Connect your Stripe account to receive payments from clients." />
    
    <div class="mt-6 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl overflow-hidden">
        <div class="p-6 sm:p-8 space-y-8">
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3 mb-2">
                    <h3 class="text-xs font-bold tracking-widest text-neutral-500 dark:text-neutral-400 uppercase">
                        Payment Gateways
                    </h3>
                    <span class="text-[10px] px-2 py-0.5 bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 font-bold rounded-full uppercase tracking-wider flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-neutral-400"></span>
                        Not Connected
                    </span>
                </div>

                <div class="p-4 sm:p-5 bg-neutral-50/50 dark:bg-neutral-800/30 rounded-xl border border-neutral-200 dark:border-neutral-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-colors hover:border-neutral-300 dark:hover:border-neutral-700">
                    <div class="flex items-center gap-4">
                        <div class="p-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-lg shrink-0 shadow-sm flex items-center justify-center w-12 h-12">
                            <svg class="w-6 h-6 text-purple-600" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M13.976 9.15c-1.399-.372-2.143-.872-2.143-1.874 0-1.161 1.09-1.93 2.656-1.93 1.967 0 3.25.753 4.256 1.706L20.12 3.84C18.665 2.213 16.31 1.25 14.28 1.25c-3.924 0-7.391 2.05-7.391 5.922 0 3.518 2.766 4.966 6.375 5.96 1.62.437 2.14.996 2.14 1.942 0 1.291-1.258 2.062-3.084 2.062-2.457 0-4.04-1.077-5.187-2.316l-1.56 3.193c1.55 1.547 3.86 2.639 6.702 2.639 4.248 0 7.644-2.155 7.644-6.059 0-3.418-2.617-4.994-5.943-5.443z" />
                            </svg>
                        </div>
                        <div class="space-y-0.5">
                            <h4 class="text-sm font-semibold text-neutral-900 dark:text-white">Stripe Integration</h4>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Accept credit cards, Apple Pay, and Google Pay.</p>
                        </div>
                    </div>
                    <button wire:click="connectStripe" class="inline-flex items-center justify-center shrink-0 w-full sm:w-auto bg-purple-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-600 dark:focus:ring-offset-neutral-900">
                        Connect with Stripe
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
