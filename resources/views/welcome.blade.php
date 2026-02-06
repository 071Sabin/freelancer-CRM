@component('layouts.app')
    <section
        class="relative overflow-hidden pt-16 pb-20 lg:pt-24 lg:pb-28 bg-white dark:bg-slate-900 transition-colors duration-300">

        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
            <div
                class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen animate-pulse">
            </div>
            <div
                class="absolute top-20 right-1/4 w-[400px] h-[400px] bg-emerald-500/10 dark:bg-emerald-500/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen">
            </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 mb-8 hover:border-emerald-500/50 transition-colors cursor-pointer group">
                <span class="flex h-2 w-2 relative">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span
                    class="text-sm font-medium text-slate-600 dark:text-slate-300 group-hover:text-emerald-600 dark:group-hover:text-emerald-400">
                    New: Native WhatsApp API Integration
                </span>
                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>

            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-6">
                Pivot from Freelancer <br class="hidden md:block" />
                to <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-emerald-500">Enterprise
                    Powerhouse.</span>
            </h1>

            <p class="mt-4 max-w-2xl mx-auto text-xl text-slate-600 dark:text-slate-300">
                Client Pivot is the only OS that unifies projects, invoices, and client communication.
                Stop app-switching and close deals directly via our <strong
                    class="text-emerald-600 dark:text-emerald-400 font-semibold">integrated WhatsApp Chat</strong>.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                <a href="#"
                    class="inline-flex justify-center items-center px-8 py-4 text-base font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-1">
                    Start Free Trial
                    <svg class="ml-2 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </a>
                <a href="#"
                    class="inline-flex justify-center items-center px-8 py-4 text-base font-semibold rounded-lg text-slate-700 dark:text-white bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                    View Live Demo
                </a>
            </div>

            <div class="mt-12">
                <p class="text-sm font-medium text-slate-400 uppercase tracking-wider">Empowering top-tier freelancers</p>
                <div
                    class="mt-4 flex justify-center gap-6 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
                    <div class="h-8 w-24 bg-slate-300 dark:bg-slate-700 rounded animate-pulse"></div>
                    <div class="h-8 w-24 bg-slate-300 dark:bg-slate-700 rounded animate-pulse delay-75"></div>
                    <div class="h-8 w-24 bg-slate-300 dark:bg-slate-700 rounded animate-pulse delay-150"></div>
                    <div class="h-8 w-24 bg-slate-300 dark:bg-slate-700 rounded animate-pulse delay-200"></div>
                </div>
            </div>

            <div class="relative mt-20">
                <div
                    class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-emerald-500 rounded-2xl blur opacity-20 dark:opacity-30">
                </div>

                <div
                    class="relative bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl shadow-2xl overflow-hidden">

                    <div
                        class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 px-4 py-3 flex items-center gap-2">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        </div>
                        <div
                            class="ml-4 bg-slate-100 dark:bg-slate-700 px-3 py-1 rounded text-xs text-slate-400 dark:text-slate-400 font-mono">
                            app.clientpivot.com/dashboard
                        </div>
                    </div>

                    <div class="grid grid-cols-12 h-[400px] md:h-[500px]">

                        <div
                            class="hidden md:block col-span-2 bg-slate-50 dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 p-4">
                            <div class="space-y-4">
                                <div class="h-8 w-8 bg-indigo-600 rounded-lg mb-8"></div>
                                <div class="h-2 w-20 bg-slate-200 dark:bg-slate-700 rounded"></div>
                                <div class="h-2 w-16 bg-slate-200 dark:bg-slate-700 rounded"></div>
                                <div class="h-2 w-24 bg-slate-200 dark:bg-slate-700 rounded"></div>
                                <div
                                    class="mt-8 p-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-100 dark:border-emerald-900/50">
                                    <div
                                        class="h-6 w-6 rounded-full bg-emerald-500 flex items-center justify-center text-white text-[10px]">
                                        WA</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-12 md:col-span-6 bg-white dark:bg-slate-800/50 p-6 md:p-8 text-left">
                            <div class="flex justify-between items-end mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">Active Projects</h3>
                                    <p class="text-sm text-slate-500">Manage your enterprise workflow</p>
                                </div>
                                <div class="px-3 py-1 bg-indigo-600 text-white text-xs rounded-md">New Invoice +</div>
                            </div>

                            <div class="space-y-3">
                                <div
                                    class="flex items-center justify-between p-3 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-lg shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-indigo-100 dark:bg-indigo-900/50"></div>
                                        <div>
                                            <div class="h-2 w-24 bg-slate-200 dark:bg-slate-600 rounded mb-1"></div>
                                            <div class="h-1.5 w-12 bg-slate-100 dark:bg-slate-700 rounded"></div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="block text-xs font-bold text-slate-700 dark:text-slate-300">$12,500</span>
                                        <span
                                            class="inline-block px-1.5 py-0.5 rounded text-[10px] bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300">Paid</span>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-between p-3 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-lg shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-purple-100 dark:bg-purple-900/50"></div>
                                        <div>
                                            <div class="h-2 w-32 bg-slate-200 dark:bg-slate-600 rounded mb-1"></div>
                                            <div class="h-1.5 w-16 bg-slate-100 dark:bg-slate-700 rounded"></div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="block text-xs font-bold text-slate-700 dark:text-slate-300">$4,200</span>
                                        <span
                                            class="inline-block px-1.5 py-0.5 rounded text-[10px] bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300">Pending</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="hidden md:block col-span-4 bg-slate-50 dark:bg-slate-900/80 border-l border-slate-200 dark:border-slate-700 flex flex-col">
                            <div
                                class="p-4 bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="relative">
                                        <div class="w-8 h-8 rounded-full bg-slate-300"></div>
                                        <div
                                            class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white dark:border-slate-800 rounded-full">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="h-2 w-20 bg-slate-200 dark:bg-slate-600 rounded mb-1"></div>
                                        <div
                                            class="text-[10px] text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                            </svg>
                                            WhatsApp Connected
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-1 p-4 space-y-3 bg-slate-50 dark:bg-slate-900 overflow-hidden relative">
                                <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]"
                                    style="background-image: radial-gradient(#4b5563 1px, transparent 1px); background-size: 20px 20px;">
                                </div>

                                <div class="flex gap-2 relative z-10">
                                    <div
                                        class="bg-white dark:bg-slate-800 p-2.5 rounded-lg rounded-tl-none shadow-sm border border-slate-100 dark:border-slate-700 max-w-[85%]">
                                        <div class="h-2 w-32 bg-slate-200 dark:bg-slate-700 rounded mb-1.5"></div>
                                        <div class="h-2 w-24 bg-slate-200 dark:bg-slate-700 rounded"></div>
                                        <span class="text-[9px] text-slate-400 mt-1 block">10:42 AM</span>
                                    </div>
                                </div>

                                <div class="flex gap-2 justify-end relative z-10">
                                    <div
                                        class="bg-emerald-100 dark:bg-emerald-900 p-2.5 rounded-lg rounded-tr-none shadow-sm max-w-[85%]">
                                        <p class="text-[10px] text-emerald-900 dark:text-emerald-100 font-medium">Invoice
                                            #1024 sent!</p>
                                        <div class="mt-2 p-2 bg-white/50 dark:bg-black/20 rounded flex items-center gap-2">
                                            <div
                                                class="w-6 h-8 bg-white dark:bg-slate-700 rounded border border-slate-200 dark:border-slate-600">
                                            </div>
                                            <div class="h-1.5 w-12 bg-emerald-800/20 dark:bg-emerald-100/30 rounded"></div>
                                        </div>
                                        <span
                                            class="text-[9px] text-emerald-700 dark:text-emerald-300 mt-1 block text-right">10:43
                                            AM ✓✓</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- Features section --}}
    <section id="features"
        class="relative py-24 bg-slate-50 dark:bg-black overflow-hidden transition-colors duration-300">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 text-center">
            <span class="text-indigo-600 dark:text-indigo-400 font-semibold tracking-wider uppercase text-sm">
                Platform Capabilities
            </span>
            <h2 class="mt-3 text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Workflow re-imagined for <br class="hidden md:block">
                <span class="relative inline-block">
                    <span class="relative z-10">high-value consultants.</span>
                    <span
                        class="absolute bottom-1 left-0 w-full h-3 bg-indigo-200 dark:bg-indigo-900/50 -rotate-1 -z-0"></span>
                </span>
            </h2>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">

            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                <div class="lg:w-1/2">
                    <div
                        class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-6">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Native WhatsApp Integration</h3>
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                        Stop forcing clients to check emails. Our API connects your dashboard directly to their WhatsApp.
                        Send invoices, updates, and files without ever touching your phone.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-slate-700 dark:text-slate-300">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Two-way sync: Chat from the web app
                        </li>
                        <li class="flex items-center gap-3 text-slate-700 dark:text-slate-300">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Automated invoice reminders
                        </li>
                    </ul>
                </div>

                <div class="lg:w-1/2 relative group">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-emerald-400 to-green-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000">
                    </div>
                    <div
                        class="relative bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 shadow-2xl overflow-hidden h-[300px] flex flex-col">
                        <div
                            class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4 mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-600"></div>
                                <div>
                                    <div class="h-2.5 w-24 bg-slate-800 dark:bg-slate-300 rounded mb-1"></div>
                                    <div class="h-2 w-12 bg-emerald-500 rounded opacity-50"></div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4 flex-1">
                            <div class="flex justify-end">
                                <div
                                    class="bg-emerald-100 dark:bg-emerald-900/50 p-3 rounded-2xl rounded-tr-none max-w-xs">
                                    <p class="text-xs text-emerald-900 dark:text-emerald-100 font-medium">Hello! Here is
                                        the updated proposal.</p>
                                </div>
                            </div>
                            <div class="flex justify-start">
                                <div class="bg-slate-100 dark:bg-slate-700 p-3 rounded-2xl rounded-tl-none max-w-xs">
                                    <p class="text-xs text-slate-700 dark:text-slate-300">Looks great! Can we proceed with
                                        the payment?</p>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <div
                                    class="bg-emerald-100 dark:bg-emerald-900/50 p-3 rounded-2xl rounded-tr-none max-w-xs shadow-sm border border-emerald-200 dark:border-emerald-800">
                                    <p class="text-xs text-emerald-900 dark:text-emerald-100 font-medium mb-2">Invoice #001
                                        Generated</p>
                                    <div
                                        class="h-6 bg-white dark:bg-slate-800 rounded flex items-center justify-center text-[10px] text-slate-500 border border-slate-200 dark:border-slate-600">
                                        View Invoice PDF</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row-reverse items-center gap-12 lg:gap-20">
                <div class="lg:w-1/2">
                    <div
                        class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Kanban & Project Tracking</h3>
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                        Manage complex deliverables with a drag-and-drop interface designed for speed. Assign tasks, set
                        milestones, and never miss a deadline again.
                    </p>
                    <div class="flex gap-4">
                        <div
                            class="px-4 py-2 bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 text-sm font-medium text-slate-600 dark:text-slate-300">
                            ✓ File Sharing
                        </div>
                        <div
                            class="px-4 py-2 bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 text-sm font-medium text-slate-600 dark:text-slate-300">
                            ✓ Time Tracking
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/2 relative group">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000">
                    </div>
                    <div
                        class="relative bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 shadow-2xl h-[300px] flex gap-4 overflow-hidden">
                        <div
                            class="w-1/3 bg-slate-50 dark:bg-slate-900/50 rounded-lg p-3 border border-slate-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-2 h-2 rounded-full bg-slate-400"></div>
                                <div class="h-2 w-12 bg-slate-300 dark:bg-slate-600 rounded"></div>
                            </div>
                            <div
                                class="bg-white dark:bg-slate-800 p-2 rounded border border-slate-200 dark:border-slate-700 shadow-sm mb-2">
                                <div class="h-1.5 w-full bg-slate-200 dark:bg-slate-600 rounded mb-2"></div>
                                <div class="h-1.5 w-1/2 bg-slate-200 dark:bg-slate-600 rounded"></div>
                            </div>
                            <div
                                class="bg-white dark:bg-slate-800 p-2 rounded border border-slate-200 dark:border-slate-700 shadow-sm">
                                <div class="h-1.5 w-full bg-slate-200 dark:bg-slate-600 rounded mb-2"></div>
                                <div class="flex justify-between mt-2">
                                    <div class="w-4 h-4 rounded-full bg-indigo-100"></div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="w-1/3 bg-slate-50 dark:bg-slate-900/50 rounded-lg p-3 border border-slate-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                <div class="h-2 w-12 bg-slate-300 dark:bg-slate-600 rounded"></div>
                            </div>
                            <div
                                class="bg-white dark:bg-slate-800 p-2 rounded border border-indigo-200 dark:border-indigo-900/50 shadow-sm ring-2 ring-indigo-500/20">
                                <div class="flex justify-between mb-2">
                                    <div class="h-1.5 w-16 bg-indigo-500 rounded"></div>
                                    <div class="text-[8px] text-slate-400">2d left</div>
                                </div>
                                <div class="h-1.5 w-full bg-slate-200 dark:bg-slate-600 rounded"></div>
                            </div>
                        </div>
                        <div
                            class="w-1/3 bg-slate-50 dark:bg-slate-900/50 rounded-lg p-3 border border-slate-100 dark:border-slate-700/50 opacity-50">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                <div class="h-2 w-12 bg-slate-300 dark:bg-slate-600 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                <div class="lg:w-1/2">
                    <div
                        class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400 mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Enterprise-Grade Invoicing</h3>
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                        Look professional from day one. Create multi-currency invoices, track view status, and accept credit
                        cards directly on the platform.
                    </p>
                    <div
                        class="inline-flex items-center px-4 py-2 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 rounded-lg text-sm font-medium border border-amber-100 dark:border-amber-800/50">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Stripe & PayPal Connected
                    </div>
                </div>

                <div class="lg:w-1/2 relative group">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-amber-400 to-orange-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000">
                    </div>
                    <div
                        class="relative bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-8 shadow-2xl h-[300px] flex flex-col items-center justify-center">

                        <div
                            class="w-48 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-lg rounded p-4 transform rotate-3 group-hover:rotate-0 transition-transform duration-500">
                            <div class="flex justify-between items-center mb-4">
                                <div class="w-6 h-6 bg-slate-800 dark:bg-slate-700 rounded"></div>
                                <div class="w-12 h-2 bg-slate-200 dark:bg-slate-700 rounded"></div>
                            </div>
                            <div class="space-y-2 mb-4">
                                <div class="w-full h-1.5 bg-slate-100 dark:bg-slate-800 rounded"></div>
                                <div class="w-full h-1.5 bg-slate-100 dark:bg-slate-800 rounded"></div>
                                <div class="w-2/3 h-1.5 bg-slate-100 dark:bg-slate-800 rounded"></div>
                            </div>
                            <div
                                class="flex justify-between items-center border-t border-slate-100 dark:border-slate-800 pt-2">
                                <div class="w-10 h-2 bg-slate-200 dark:bg-slate-700 rounded"></div>
                                <div
                                    class="w-16 h-4 bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-400 text-[8px] flex items-center justify-center font-bold rounded">
                                    $4,500.00
                                </div>
                            </div>
                        </div>

                        <div
                            class="absolute bottom-6 right-6 bg-white dark:bg-slate-700 px-4 py-2 rounded-lg shadow-xl border border-slate-100 dark:border-slate-600 flex items-center gap-2 animate-bounce">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-xs font-bold text-slate-800 dark:text-white">Invoice Paid</span>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="mt-24 pt-20 border-t border-slate-200 dark:border-slate-800 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 text-center">

                <div class="p-6">
                    <div
                        class="mx-auto w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-lg flex items-center justify-center text-slate-600 dark:text-slate-300 mb-4">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-900 dark:text-white">Bank-Level Security</h4>
                    <p class="text-sm text-slate-500 mt-2">256-bit encryption for all your data.</p>
                </div>

                <div class="p-6">
                    <div
                        class="mx-auto w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-lg flex items-center justify-center text-slate-600 dark:text-slate-300 mb-4">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-900 dark:text-white">Multi-Currency</h4>
                    <p class="text-sm text-slate-500 mt-2">Bill clients in USD, EUR, GBP, and more.</p>
                </div>

                <div class="p-6">
                    <div
                        class="mx-auto w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-lg flex items-center justify-center text-slate-600 dark:text-slate-300 mb-4">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-900 dark:text-white">24/7 Support</h4>
                    <p class="text-sm text-slate-500 mt-2">We are here when you need us.</p>
                </div>

            </div>
        </div>
    </section>
@endcomponent
