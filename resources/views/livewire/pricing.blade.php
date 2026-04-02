<div class="bg-neutral-50 dark:bg-neutral-900 pb-24 pt-12">

    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        <div class="mx-auto max-w-3xl text-center flex flex-col items-center gap-6">

            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-500/10 ring-1 ring-inset ring-indigo-200/50 dark:ring-indigo-400/20 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-indigo-700 dark:text-indigo-400">
                    Stop giving away 20% to freelance marketplaces
                </p>
            </div>

            <h1 class="font-pricing text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-white sm:text-5xl">
                Plans & Pricing
            </h1>

            <h2 class="text-xl font-semibold tracking-tight text-neutral-800 dark:text-neutral-200 sm:text-2xl">
                Keep <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-indigo-500 dark:from-indigo-400 dark:to-indigo-300">100%
                    of your revenue.</span> Scale infinitely.
            </h2>

            <p class="mx-auto max-w-2xl text-sm leading-relaxed text-neutral-600 dark:text-neutral-400">
                ClientPivot replaces expensive platforms. Get a unified dashboard,
                <strong class="font-medium text-neutral-900 dark:text-white">zero-commission invoicing</strong>,
                automated WhatsApp updates, and a frictionless client portal, all in one predictable subscription.
            </p>
        </div>


        <div class="flex flex-col items-center justify-center pt-4 pb-12">
            <div
                class="relative flex items-center p-1 bg-neutral-100 dark:bg-neutral-900 rounded-full border border-neutral-200 dark:border-neutral-800 w-fit mx-auto shadow-inner">

                <div
                    class="absolute inset-y-1 left-1 w-[calc(50%-4px)] {{ $isYearly ? 'translate-x-full' : 'translate-x-0' }} bg-white dark:bg-neutral-800 rounded-full shadow-sm border border-neutral-200/50 dark:border-neutral-700/50 transition-transform duration-300 ease-in-out">
                </div>

                <button wire:click="setMonthly" type="button"
                    class="relative z-10 flex items-center justify-center w-32 py-2.5 text-sm transition-colors cursor-pointer {{ !$isYearly ? 'font-semibold text-neutral-900 dark:text-white' : 'font-medium text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}">
                    Monthly
                </button>

                <button wire:click="setYearly" type="button"
                    class="relative z-10 flex items-center justify-center w-32 py-2.5 text-sm transition-colors cursor-pointer {{ $isYearly ? 'font-semibold text-neutral-900 dark:text-white' : 'font-medium text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}">
                    Yearly
                </button>

                {{-- <span class="absolute -top-3.5 -right-3 sm:-right-6 flex items-center z-20">
                    <span
                        class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-20"></span>
                    <span
                        class="relative inline-flex items-center rounded-full bg-emerald-100 dark:bg-emerald-500/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400 ring-1 ring-inset ring-emerald-600/20 dark:ring-emerald-500/20 shadow-sm whitespace-nowrap">
                        Save 20%
                    </span>
                </span> --}}

            </div>

            <p class="mt-4 text-xs text-neutral-500 dark:text-neutral-400">
                Commit annually and get <strong class="text-neutral-700 dark:text-neutral-300">2 months</strong> totally
                free.
            </p>
        </div>

        <div
            class="isolate mx-auto mt-10 grid max-w-md grid-cols-1 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-3 lg:gap-x-8 xl:gap-x-12 lg:items-center relative z-10">
            <div class="absolute inset-x-0 top-1/2 -z-10 -translate-y-1/2 flex justify-center overflow-hidden pointer-events-none blur-3xl opacity-0 dark:opacity-30"
                aria-hidden="true">
                <div
                    class="aspect-[1318/752] w-[82.375rem] flex-none bg-gradient-to-r from-indigo-500 to-indigo-900 opacity-25">
                </div>
            </div>

            <div
                class="rounded-3xl bg-white dark:bg-neutral-800/70 p-8 ring-1 ring-indigo-200 dark:ring-indigo-800 xl:p-10 hover:shadow-lg dark:hover:bg-neutral-900 transition-all duration-300">
                <div class="flex items-center justify-between gap-x-4">
                    <h3 id="tier-starter" class="text-3xl font-semibold leading-8 text-neutral-900 dark:text-white">
                        Starter</h3>
                </div>
                <p class="mt-4 text-sm leading-6 text-neutral-500 dark:text-neutral-400">Perfect for solo freelancers
                    building their client base.</p>
                <p class="mt-6 flex items-baseline gap-x-1">
                    <span
                        class="text-4xl font-bold tracking-tight text-neutral-900 dark:text-white">${{ $starterPrice }}</span>
                    <span class="text-sm font-semibold leading-6 text-neutral-500 dark:text-neutral-400">/month</span>
                </p>
                <button wire:click="subscribeToPlan('starter')"
                    class="mt-6 block cursor-pointer rounded-xl px-3 w-full py-3 text-center text-sm font-semibold leading-6 text-indigo-600 dark:text-indigo-400 ring-1 ring-inset ring-indigo-200 dark:ring-indigo-500/30 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 hover:ring-indigo-300 dark:hover:ring-indigo-400 transition-all duration-200">
                    Start Free Trial
                </button>

                <ul role="list" class="mt-8 space-y-4 text-sm leading-6 text-neutral-600 dark:text-neutral-300">
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        0% Platform Commission (Direct Stripe Payouts)
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Up to 3 Active Clients
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Up to 6 Invoices per month
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Basic No-Login Client Portal
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Standard Email Reminders
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Basic Customer Support
                    </li>
                </ul>
            </div>

            <div
                class="relative rounded-3xl bg-white dark:bg-neutral-900 p-8 shadow-2xl dark:shadow-indigo-900/30 ring-2 ring-indigo-600 dark:ring-indigo-500 lg:scale-105 z-10 xl:p-10">

                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center justify-center z-10">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 blur-md opacity-40 dark:opacity-60 rounded-full">
                    </div>

                    <p
                        class="relative rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-500 dark:to-purple-500 px-4 py-1.5 text-[11px] font-bold uppercase tracking-widest text-white shadow-sm flex items-center gap-1.5 whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-3.5 h-3.5 text-indigo-200 dark:text-indigo-100">
                            <path fill-rule="evenodd"
                                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                                clip-rule="evenodd" />
                        </svg>
                        Most Popular
                    </p>
                </div>

                <div class="flex items-center justify-between gap-x-4">
                    <h3 id="tier-pro" class="text-3xl font-bold leading-8 text-neutral-900 dark:text-white">Pro</h3>
                </div>
                <p class="mt-4 text-sm leading-6 text-neutral-500 dark:text-neutral-400">The complete powerhouse for
                    full-time professionals.</p>
                <p class="mt-6 flex items-baseline gap-x-1">
                    <span
                        class="text-4xl font-extrabold tracking-tight text-neutral-900 dark:text-white">${{ $proPrice }}</span>
                    <span class="text-sm font-semibold leading-6 text-neutral-500 dark:text-neutral-400">/month</span>
                </p>
                <button wire:click="subscribeToPlan('pro')" aria-describedby="tier-pro"
                    class="mt-6 block rounded-xl cursor-pointer w-full bg-indigo-600 dark:bg-indigo-500 px-3 py-3 text-center text-sm font-bold leading-6 text-white shadow-md hover:bg-indigo-500 dark:hover:bg-indigo-400 hover:shadow-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all duration-300 transform hover:-translate-y-0.5">
                    Upgrade to Pro
                </button>
                <ul role="list" class="mt-8 space-y-4 text-sm leading-6 text-neutral-600 dark:text-neutral-300">
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        <strong class="font-semibold text-neutral-900 dark:text-white">0% Platform Commission</strong>
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        <strong class="font-semibold text-neutral-900 dark:text-white">Unlimited</strong> Clients &amp;
                        Invoices
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Automated WhatsApp Notifications
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Advanced No-Login Portal & Live Tracking
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Custom Logo &amp; Branding on Invoices
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Remove "ClientPivot" Watermark
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Priority 24/7 Support
                    </li>
                </ul>
            </div>

            <div
                class="rounded-3xl bg-white dark:bg-neutral-800/70 p-8 ring-1 ring-indigo-200 dark:ring-indigo-800 xl:p-10 hover:shadow-lg dark:hover:bg-neutral-900 transition-all duration-300">
                <div class="flex items-center justify-between gap-x-4">
                    <h3 id="tier-agency" class="text-3xl font-semibold leading-8 text-neutral-900 dark:text-white">
                        Agency</h3>
                </div>
                <p class="mt-4 text-sm leading-6 text-neutral-500 dark:text-neutral-400">Advanced tools for growing
                    studios and boutique agencies.</p>
                <p class="mt-6 flex items-baseline gap-x-1">
                    <span class="text-4xl font-bold tracking-tight text-neutral-900 dark:text-white">
                        ${{ $agencyPrice }} </span>
                    <span class="text-sm font-semibold leading-6 text-neutral-500 dark:text-neutral-400">/month</span>
                </p>
                <button wire:click="subscribeToPlan('agency')" aria-describedby="tier-agency"
                    class="mt-6 block w-full cursor-pointer rounded-xl px-3 py-3 text-center text-sm font-semibold leading-6 text-indigo-600 dark:text-indigo-400 ring-1 ring-inset ring-indigo-200 dark:ring-indigo-500/30 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 hover:ring-indigo-300 dark:hover:ring-indigo-400 transition-all duration-200">Start
                    Agency Plan
                </button>
                <ul role="list" class="mt-8 space-y-4 text-sm leading-6 text-neutral-600 dark:text-neutral-300">
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        <strong class="font-semibold text-neutral-900 dark:text-white">Everything in Pro</strong>
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Add up to 5 Team Members
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            Custom Domain for Client Portal
                            <span class="text-xs text-neutral-500 dark:text-neutral-400 block mt-0.5">(e.g.,
                                portal.youragency.com)</span>
                        </div>
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Advanced Revenue Analytics &amp; CSV Export
                    </li>
                    <li class="flex gap-x-3 items-start">
                        <svg class="h-6 w-5 flex-none text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Dedicated Account Manager
                    </li>
                </ul>
            </div>
        </div>
    </div>



    {{-- FAQ sections --}}
    <section class="bg-white px-4 py-16 sm:px-6 sm:py-24 lg:px-8 dark:bg-neutral-950">
        <div class="mx-auto max-w-3xl divide-y divide-neutral-200 dark:divide-neutral-800">

            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-neutral-900 dark:text-white">
                    Frequently asked questions
                </h2>
                <p class="mt-4 text-base sm:text-lg text-neutral-600 dark:text-neutral-400">
                    Everything you need to know about the product and billing.
                </p>
            </div>

            <details class="group py-6 [&_summary::-webkit-details-marker]:hidden">
                <summary
                    class="flex cursor-pointer items-center justify-between gap-1.5 text-neutral-900 dark:text-white">
                    <h3
                        class="text-base sm:text-lg font-semibold hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        What if I'm not satisfied with the product?
                    </h3>
                    <span class="relative h-5 w-5 shrink-0 text-indigo-600 dark:text-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute inset-0 h-5 w-5 opacity-100 group-open:opacity-0 transition-opacity duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute inset-0 h-5 w-5 opacity-0 group-open:opacity-100 transition-opacity duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                        </svg>
                    </span>
                </summary>
                <p class="mt-4 text-sm sm:text-base leading-relaxed text-neutral-600 dark:text-neutral-400 pr-8">
                    We offer a 14-day, no-questions-asked money-back guarantee. If you realize it's not the right fit
                    within your first two weeks, simply email support and we'll refund your entire purchase immediately.
                </p>
            </details>

            <details class="group py-6 [&_summary::-webkit-details-marker]:hidden">
                <summary
                    class="flex cursor-pointer items-center justify-between gap-1.5 text-neutral-900 dark:text-white">
                    <h3
                        class="text-base sm:text-lg font-semibold hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        Can I upgrade or downgrade my plan later?
                    </h3>
                    <span class="relative h-5 w-5 shrink-0 text-indigo-600 dark:text-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute inset-0 h-5 w-5 opacity-100 group-open:opacity-0 transition-opacity duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute inset-0 h-5 w-5 opacity-0 group-open:opacity-100 transition-opacity duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                        </svg>
                    </span>
                </summary>
                <p class="mt-4 text-sm sm:text-base leading-relaxed text-neutral-600 dark:text-neutral-400 pr-8">
                    Absolutely. You can change your plan at any time right from your dashboard. If you upgrade, you'll
                    be prorated the difference. If you downgrade, you'll be credited on your next billing cycle.
                </p>
            </details>

            <details class="group py-6 [&_summary::-webkit-details-marker]:hidden">
                <summary
                    class="flex cursor-pointer items-center justify-between gap-1.5 text-neutral-900 dark:text-white">
                    <h3
                        class="text-base sm:text-lg font-semibold hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        Do I need a credit card to start the free trial?
                    </h3>
                    <span class="relative h-5 w-5 shrink-0 text-indigo-600 dark:text-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute inset-0 h-5 w-5 opacity-100 group-open:opacity-0 transition-opacity duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute inset-0 h-5 w-5 opacity-0 group-open:opacity-100 transition-opacity duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                        </svg>
                    </span>
                </summary>
                <p class="mt-4 text-sm sm:text-base leading-relaxed text-neutral-600 dark:text-neutral-400 pr-8">
                    No! We want you to experience the full value of the platform completely risk-free. You only enter
                    your payment details when you are ready to subscribe.
                </p>
            </details>

            <details class="group py-6 [&_summary::-webkit-details-marker]:hidden">
                <summary
                    class="flex cursor-pointer items-center justify-between gap-1.5 text-neutral-900 dark:text-white">
                    <h3
                        class="text-base sm:text-lg font-semibold hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        Am I locked into a long-term contract?
                    </h3>
                    <span class="relative h-5 w-5 shrink-0 text-indigo-600 dark:text-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute inset-0 h-5 w-5 opacity-100 group-open:opacity-0 transition-opacity duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute inset-0 h-5 w-5 opacity-0 group-open:opacity-100 transition-opacity duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                        </svg>
                    </span>
                </summary>
                <p class="mt-4 text-sm sm:text-base leading-relaxed text-neutral-600 dark:text-neutral-400 pr-8">
                    Not at all. If you choose the monthly plan, you are billed month-to-month and can cancel instantly
                    with one click. If you choose the annual plan (and save 20%), you are billed once per year.
                </p>
            </details>

        </div>

        <div class="mt-12 text-center sm:mt-16">
            <p class="text-sm sm:text-base text-neutral-600 dark:text-neutral-400">
                Still have questions?
                <a href="#"
                    class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 underline underline-offset-4 transition-colors">
                    Chat with our team
                </a>
            </p>
        </div>
    </section>
</div>
