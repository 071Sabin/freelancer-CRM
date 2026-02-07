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
        class="relative py-24 bg-white dark:bg-slate-950 overflow-hidden transition-colors duration-500">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-500/10 dark:bg-indigo-600/10 blur-[120px] rounded-full pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 right-1/4 w-96 h-96 bg-emerald-500/10 dark:bg-emerald-600/10 blur-[120px] rounded-full pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-24">
                <h2 class="text-base font-semibold text-indigo-600 dark:text-indigo-400 tracking-wide uppercase">Advanced
                    Freelance Ecosystem</h2>
                <p class="mt-2 text-4xl font-extrabold text-slate-900 dark:text-white sm:text-5xl tracking-tight">
                    Everything you need to scale to <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-emerald-500">6-figures.</span>
                </p>
            </div>

            <div class="space-y-32">

                <div class="flex flex-col lg:flex-row items-center gap-16">
                    <div class="lg:w-1/2">
                        <div
                            class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Unified Client Inbox</h3>
                        <p class="text-lg text-slate-600 dark:text-slate-400 mb-8">
                            Stop switching between WhatsApp, Gmail, and Slack. Client Pivot syncs every conversation into
                            one thread. Reply via web, they receive it on WhatsApp.
                        </p>
                        <ul class="grid grid-cols-1 gap-4">
                            <li class="flex items-center gap-3 text-slate-700 dark:text-slate-300">
                                <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Real-time WhatsApp API integration
                            </li>
                            <li class="flex items-center gap-3 text-slate-700 dark:text-slate-300">
                                <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Email thread nesting (Gmail/Outlook sync)
                            </li>
                        </ul>
                    </div>
                    <div class="lg:w-1/2 relative">
                        <div
                            class="bg-slate-100 dark:bg-slate-900 rounded-2xl p-4 shadow-2xl border border-slate-200 dark:border-slate-800">
                            <div class="flex flex-col space-y-3">
                                <div class="flex items-center gap-3 p-3 bg-white dark:bg-slate-800 rounded-lg shadow-sm">
                                    <div
                                        class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white">
                                        JD</div>
                                    <div class="flex-1">
                                        <div class="h-2 w-24 bg-slate-200 dark:bg-slate-700 rounded mb-2"></div>
                                        <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded"></div>
                                    </div>
                                    <span
                                        class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded">WhatsApp</span>
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-white dark:bg-slate-800 rounded-lg opacity-60">
                                    <div
                                        class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-white">
                                        SK</div>
                                    <div class="flex-1">
                                        <div class="h-2 w-24 bg-slate-200 dark:bg-slate-700 rounded mb-2"></div>
                                        <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded"></div>
                                    </div>
                                    <span class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded">Email</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row-reverse items-center gap-16">
                    <div class="lg:w-1/2">
                        <div
                            class="flex items-center justify-center w-12 h-12 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">AI Scope-Creep Guardian</h3>
                        <p class="text-lg text-slate-600 dark:text-slate-400 mb-8">
                            The "Million Dollar" feature. Our AI analyzes client messages. If they ask for extra features
                            not in the contract, it flags the message and suggests an upsell invoice.
                        </p>
                        <div
                            class="p-4 bg-purple-50 dark:bg-purple-900/20 border border-purple-100 dark:border-purple-800 rounded-xl">
                            <p class="text-sm font-semibold text-purple-900 dark:text-purple-300 italic">"Hey, can we also
                                add a login page for this?"</p>
                            <div class="mt-2 flex items-center gap-2 text-xs font-bold text-purple-600">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" />
                                </svg>
                                SYSTEM ALERT: New feature detected. Click to send $500 add-on invoice.
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-1/2 bg-slate-900 rounded-2xl p-8 shadow-2xl relative overflow-hidden group">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div class="relative z-10 text-white font-mono text-sm">
                            <p class="text-emerald-400">// Scanning incoming WhatsApp message...</p>
                            <p class="mt-2">Client: "Can you change the logo colors too?"</p>
                            <p class="mt-4 text-purple-400">Match found: [Graphic Design - Revisions]</p>
                            <p class="text-purple-400">Status: Out of Scope</p>
                            <div
                                class="mt-6 h-10 w-full bg-purple-600 rounded flex items-center justify-center font-sans font-bold">
                                Generate Upsell Invoice</div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row items-center gap-16">
                    <div class="lg:w-1/2">
                        <div
                            class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Your Brand, Their Portal</h3>
                        <p class="text-lg text-slate-600 dark:text-slate-400 mb-8">
                            Give your clients a login URL (portal.yourname.com). They can view their project timeline,
                            download invoices, and upload files without ever bothering you on Sunday morning.
                        </p>
                        <div class="flex gap-4 flex-wrap">
                            <span
                                class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold rounded-full">Custom
                                Domain Support</span>
                            <span
                                class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold rounded-full">Automated
                                Onboarding</span>
                            <span
                                class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold rounded-full">File
                                Version Control</span>
                        </div>
                    </div>
                    <div class="lg:w-1/2">
                        <div
                            class="relative bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-2xl overflow-hidden aspect-video">
                            <div
                                class="bg-slate-50 dark:bg-slate-800 px-4 py-2 border-b border-slate-200 dark:border-slate-700 flex justify-between">
                                <div class="text-[10px] text-slate-400 font-mono italic">portal.freelancer.com/client-x
                                </div>
                                <div class="flex gap-1">
                                    <div class="w-2 h-2 rounded-full bg-red-400"></div>
                                    <div class="w-2 h-2 rounded-full bg-amber-400"></div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="h-4 w-32 bg-slate-200 dark:bg-slate-700 rounded mb-6"></div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div
                                        class="h-24 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800 p-4">
                                        <p class="text-[10px] text-indigo-500 font-bold">Project Progress</p>
                                        <p class="text-xl font-black dark:text-white">84%</p>
                                    </div>
                                    <div
                                        class="h-24 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800 p-4">
                                        <p class="text-[10px] text-emerald-500 font-bold">Next Meeting</p>
                                        <p class="text-sm font-black dark:text-white">Tomorrow, 10 AM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-32 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4 sm:px-0">
                <div
                    class="group relative p-8 rounded-3xl bg-white dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div
                        class="absolute inset-0 rounded-3xl bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>

                    <div class="relative z-10">
                        <div
                            class="mb-5 inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-widest">Smart
                            Scheduling</p>
                        <h4 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white mt-2">Calendly Killer</h4>
                        <p class="text-sm lg:text-base text-slate-500 dark:text-slate-400 mt-3 leading-relaxed">
                            Native availability booking. Sync your calendar and let clients book discovery calls without
                            ever leaving your ecosystem.
                        </p>
                    </div>
                </div>

                <div
                    class="group relative p-8 rounded-3xl bg-white dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div
                        class="absolute inset-0 rounded-3xl bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>

                    <div class="relative z-10">
                        <div
                            class="mb-5 inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <p class="text-emerald-600 dark:text-emerald-400 text-xs font-bold uppercase tracking-widest">
                            Financial Insights</p>
                        <h4 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white mt-2">Cashflow Radar</h4>
                        <p class="text-sm lg:text-base text-slate-500 dark:text-slate-400 mt-3 leading-relaxed">
                            Stop guessing. Predictive analytics forecast your next 3 months of revenue based on active
                            milestones and recurring retainers.
                        </p>
                    </div>
                </div>

                <div
                    class="group relative p-8 rounded-3xl bg-white dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div
                        class="absolute inset-0 rounded-3xl bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>

                    <div class="relative z-10">
                        <div
                            class="mb-5 inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-amber-600 dark:text-amber-400 text-xs font-bold uppercase tracking-widest">
                            Auto-Billing</p>
                        <h4 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white mt-2">Subscription SaaS
                        </h4>
                        <p class="text-sm lg:text-base text-slate-500 dark:text-slate-400 mt-3 leading-relaxed">
                            Transform from "one-off" projects to high-margin recurring revenue. Turn any project into a
                            monthly subscription in one click.
                        </p>
                    </div>
                </div>

                <div
                    class="group relative p-8 rounded-3xl bg-white dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div
                        class="absolute inset-0 rounded-3xl bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>

                    <div class="relative z-10">
                        <div
                            class="mb-5 inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                        <p class="text-purple-600 dark:text-purple-400 text-xs font-bold uppercase tracking-widest">Global
                            Ops</p>
                        <h4 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white mt-2">E-Signature</h4>
                        <p class="text-sm lg:text-base text-slate-500 dark:text-slate-400 mt-3 leading-relaxed">
                            Send legally binding contracts that get signed directly in your portal. No more PDFs or
                            third-party signing apps needed.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endcomponent
