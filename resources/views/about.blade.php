@component('layouts.app')
    <section id="about" class="relative py-24 bg-white dark:bg-slate-900 overflow-hidden transition-colors duration-300">

        <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05] pointer-events-none"
            style="background-image: linear-gradient(#4b5563 1px, transparent 1px), linear-gradient(to right, #4b5563 1px, transparent 1px); background-size: 40px 40px;">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center mb-24">

                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800 mb-6">
                        <span class="text-xs font-bold uppercase tracking-wider">Our Mission</span>
                    </div>

                    <h2 class="text-4xl md:text-5xl font-bold tracking-tight text-slate-900 dark:text-white mb-6">
                        We’re building the <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-emerald-500">Operating
                            System</span> for the modern freelancer.
                    </h2>

                    <div class="prose prose-lg text-slate-500 dark:text-slate-400">
                        <p class="mb-4">
                            For too long, freelancers have been forced to juggle a dozen different apps: one for invoices,
                            one for project boards, and personal WhatsApp for client chats. It was chaos.
                        </p>
                        <p class="mb-6">
                            <strong>Client Pivot</strong> changes the game. We centralized the entire freelance workflow
                            into one enterprise-grade dashboard. We didn't just build a CRM; we built a communication engine
                            that bridges the gap between professional project management and the speed of WhatsApp.
                        </p>
                    </div>

                    <div class="flex items-center gap-4 mt-8 pt-8 border-t border-slate-100 dark:border-slate-800">
                        <div class="flex -space-x-2">
                            <div class="w-10 h-10 rounded-full border-2 border-white dark:border-slate-900 bg-slate-200">
                            </div>
                            <div class="w-10 h-10 rounded-full border-2 border-white dark:border-slate-900 bg-slate-300">
                            </div>
                            <div class="w-10 h-10 rounded-full border-2 border-white dark:border-slate-900 bg-slate-400">
                            </div>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-slate-900 dark:text-white">Trusted by 10,000+ Pros</p>
                            <p class="text-slate-500 dark:text-slate-500">From designers to consultants.</p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div
                        class="relative z-10 bg-slate-50 dark:bg-slate-800 rounded-2xl p-8 border border-slate-200 dark:border-slate-700 shadow-2xl">
                        <div class="flex justify-between items-center mb-8">
                            <div class="flex gap-2">
                                <div class="w-3 h-3 rounded-full bg-slate-300 dark:bg-slate-600"></div>
                                <div class="w-3 h-3 rounded-full bg-slate-300 dark:bg-slate-600"></div>
                            </div>
                            <div class="h-2 w-20 bg-slate-200 dark:bg-slate-700 rounded"></div>
                        </div>

                        <div class="space-y-4">
                            <div
                                class="flex items-center justify-between p-4 rounded-lg bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 opacity-50 grayscale">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-red-100 dark:bg-red-900/20 rounded text-red-600 dark:text-red-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="h-2 w-24 bg-slate-200 dark:bg-slate-700 rounded mb-1"></div>
                                        <div class="text-xs text-slate-400">Disconnected Tools</div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-center text-slate-300 dark:text-slate-600">
                                <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </div>

                            <div
                                class="flex items-center justify-between p-5 rounded-xl bg-gradient-to-r from-indigo-50 to-emerald-50 dark:from-indigo-900/20 dark:to-emerald-900/20 border border-indigo-100 dark:border-indigo-800 shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="p-2.5 bg-indigo-600 rounded-lg text-white shadow-lg shadow-indigo-500/30">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white">Unified Workflow</h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">Projects + Invoices + WhatsApp
                                        </p>
                                    </div>
                                </div>
                                <div class="text-emerald-600 dark:text-emerald-400 font-bold text-sm">Active</div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -top-10 -right-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl -z-10"></div>
                    <div class="absolute -bottom-10 -left-10 w-72 h-72 bg-indigo-500/20 rounded-full blur-3xl -z-10"></div>
                </div>
            </div>

            <div class="mb-12">
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-8 text-center md:text-left">
                    Everything you need to run your empire
                </h3>

                <div class="grid md:grid-cols-3 gap-8">

                    <div
                        class="group p-8 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-500 transition-all hover:-translate-y-1">
                        <div
                            class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Project Command</h4>
                        <p class="text-slate-500 dark:text-slate-400 leading-relaxed">
                            Kanban boards, milestone tracking, and file sharing. Keep every deliverable on track without
                            leaving the dashboard.
                        </p>
                    </div>

                    <div
                        class="group p-8 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-500 transition-all hover:-translate-y-1">
                        <div
                            class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Smart Invoicing</h4>
                        <p class="text-slate-500 dark:text-slate-400 leading-relaxed">
                            Create beautiful invoices in seconds. Track payments, send reminders, and manage your
                            freelancing revenue stream.
                        </p>
                    </div>

                    <div
                        class="group relative p-8 rounded-2xl bg-slate-900 dark:bg-slate-800 border border-slate-800 dark:border-emerald-500/30 overflow-hidden transition-all hover:-translate-y-1">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-emerald-900/20 to-transparent dark:from-emerald-500/10 pointer-events-none">
                        </div>

                        <div class="relative z-10">
                            <div
                                class="w-12 h-12 bg-emerald-500 text-white rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-emerald-500/20">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-white mb-3">WhatsApp API Engine</h4>
                            <p class="text-slate-400 leading-relaxed">
                                The core of Client Pivot. Send updates, receive feedback, and close deals via our native
                                WhatsApp integration.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-800 pt-12">
                <dl class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-8 text-center">
                    <div>
                        <dt class="text-base font-medium text-slate-500 dark:text-slate-400">Transactions Processed</dt>
                        <dd class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">$2M+</dd>
                    </div>
                    <div>
                        <dt class="text-base font-medium text-slate-500 dark:text-slate-400">Messages Sent</dt>
                        <dd class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">500k+</dd>
                    </div>
                    <div>
                        <dt class="text-base font-medium text-slate-500 dark:text-slate-400">Uptime</dt>
                        <dd class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">99.9%</dd>
                    </div>
                    <div>
                        <dt class="text-base font-medium text-slate-500 dark:text-slate-400">Active Countries</dt>
                        <dd class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">40+</dd>
                    </div>
                </dl>
            </div>

        </div>
    </section>
@endcomponent
