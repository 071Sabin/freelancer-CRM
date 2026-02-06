@component('layouts.app')
    <section id="pricing" class="relative py-24 bg-white dark:bg-slate-900 overflow-hidden transition-colors duration-300">

        <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05] pointer-events-none"
            style="background-image: radial-gradient(#4b5563 1px, transparent 1px); background-size: 30px 30px;">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16">
            <h2 class="text-indigo-600 dark:text-indigo-400 font-semibold tracking-wider uppercase text-sm mb-3">
                Simple Pricing
            </h2>
            <h3 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-6">
                Stop paying for <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-emerald-500">5 different
                    tools.</span>
            </h3>
            <p class="max-w-2xl mx-auto text-lg text-slate-600 dark:text-slate-400">
                Client Pivot replaces Trello, QuickBooks, and Business WhatsApp API providers. One dashboard, one
                subscription.
            </p>

            <div x-data="{ annual: true }" class="mt-8 flex justify-center items-center gap-3">
                <span class="text-sm font-medium"
                    :class="annual ? 'text-slate-500 dark:text-slate-400' : 'text-slate-900 dark:text-white'">Monthly</span>
                <button @click="annual = !annual"
                    class="relative w-14 h-8 rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    :class="annual ? 'bg-indigo-600' : 'bg-slate-200 dark:bg-slate-700'">
                    <span
                        class="absolute left-1 top-1 bg-white w-6 h-6 rounded-full shadow-sm transition-transform duration-200"
                        :class="annual ? 'translate-x-6' : 'translate-x-0'"></span>
                </button>
                <span class="text-sm font-medium"
                    :class="annual ? 'text-slate-900 dark:text-white' : 'text-slate-500 dark:text-slate-400'">
                    Yearly <span class="text-emerald-500 text-xs font-bold ml-1 uppercase">(Save 20%)</span>
                </span>
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 items-start">

                <div
                    class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-8 border border-slate-200 dark:border-slate-700 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-300 relative group">
                    <div class="mb-6">
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white">Starter</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">Perfect for side-hustlers.</p>
                    </div>
                    <div class="mb-6 flex items-baseline gap-1">
                        <span class="text-4xl font-extrabold text-slate-900 dark:text-white">$19</span>
                        <span class="text-slate-500 dark:text-slate-400">/mo</span>
                    </div>

                    <a href="{{ route('register') }}"
                        class="block w-full py-3 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-200 font-semibold text-center hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        Start Free Trial
                    </a>

                    <ul class="mt-8 space-y-4 text-sm text-slate-600 dark:text-slate-300">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Up to 3 Clients
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Unlimited Invoicing
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Basic Project Boards
                        </li>
                        <li class="flex items-center gap-3 text-slate-400 dark:text-slate-600 decoration-slate-400/50">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            WhatsApp API Integration
                        </li>
                    </ul>
                </div>

                <div
                    class="relative bg-white dark:bg-slate-900 rounded-2xl p-8 border-2 border-indigo-600 shadow-2xl scale-105 z-10">
                    <div
                        class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-gradient-to-r from-indigo-600 to-emerald-500 text-white px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide shadow-lg">
                        Most Popular
                    </div>

                    <div class="mb-6">
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white">Professional</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">For full-time freelancers.</p>
                    </div>
                    <div class="mb-6 flex items-baseline gap-1">
                        <span class="text-5xl font-extrabold text-slate-900 dark:text-white">$49</span>
                        <span class="text-slate-500 dark:text-slate-400">/mo</span>
                    </div>

                    <a href="{{ route('register') }}"
                        class="block w-full py-4 px-6 bg-indigo-600 text-white rounded-lg font-bold text-center hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all hover:-translate-y-1">
                        Get Started Now
                    </a>

                    <ul class="mt-8 space-y-4 text-sm text-slate-700 dark:text-slate-200">
                        <li class="flex items-center gap-3 font-medium">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Unlimited Clients
                        </li>
                        <li class="flex items-center gap-3 font-medium">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <strong>Native WhatsApp Chat</strong>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Automated Payment Reminders
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Custom Domain Invoices
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Priority Email Support
                        </li>
                    </ul>
                </div>

                <div
                    class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-8 border border-slate-200 dark:border-slate-700 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-300">
                    <div class="mb-6">
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white">Agency</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">Scaling with a team.</p>
                    </div>
                    <div class="mb-6 flex items-baseline gap-1">
                        <span class="text-4xl font-extrabold text-slate-900 dark:text-white">$99</span>
                        <span class="text-slate-500 dark:text-slate-400">/mo</span>
                    </div>

                    <a href="#"
                        class="block w-full py-3 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-200 font-semibold text-center hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        Contact Sales
                    </a>

                    <ul class="mt-8 space-y-4 text-sm text-slate-600 dark:text-slate-300">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Everything in Professional
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Up to 5 Team Members
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Advanced API Access
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Dedicated Account Manager
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            White Label Dashboard
                        </li>
                    </ul>
                </div>

            </div>

            <div class="mt-16 text-center">
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Trusted payments via Stripe & PayPal</p>
                <div class="flex justify-center gap-4 opacity-50 grayscale hover:grayscale-0 transition-all">
                    <div class="h-6 w-12 bg-slate-300 dark:bg-slate-700 rounded"></div>
                    <div class="h-6 w-12 bg-slate-300 dark:bg-slate-700 rounded"></div>
                    <div class="h-6 w-12 bg-slate-300 dark:bg-slate-700 rounded"></div>
                </div>
            </div>
        </div>
    </section>
@endcomponent
