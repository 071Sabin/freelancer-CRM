<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'ClientPivot' }}</title>

    <!-- Fonts -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('uploads/clientpivot-logo-cropped.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('uploads/clientpivot-logo-cropped.png') }}">

    @livewireStyles
    @fluxAppearance
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    @vite('resources/css/app.css')

    <style>
        html {
            scroll-behavior: smooth;
        }

        /* Glowing radial background utilities */
        .hero-glow {
            position: relative;
            isolation: isolate;
        }

        .hero-glow::before {
            content: "";
            position: absolute;
            inset: -50px;
            z-index: -1;
            background: radial-gradient(circle at center,
                    rgba(99, 102, 241, 0.35) 0%,
                    rgba(99, 102, 241, 0.12) 40%,
                    rgba(0, 0, 0, 0) 70%);
            filter: blur(80px);
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .dark .hero-glow::before {
            background: radial-gradient(circle at center,
                    rgba(139, 92, 246, 0.4) 0%,
                    rgba(139, 92, 246, 0.18) 35%,
                    rgba(0, 0, 0, 0) 70%);
            filter: blur(110px);
            opacity: 0.9;
        }
    </style>

</head>

<body class="bg-white dark:bg-neutral-800">

    <!-- Navigation -->
    @guest('web')
        <nav x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
            class="fixed top-0 w-full z-50 transition-all duration-500" :class="{ 'py-3': scrolled, 'py-5': !scrolled }">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div :class="{
                    'bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl border-slate-200/50 dark:border-slate-700/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)]': scrolled,
                    'bg-transparent border-transparent': !scrolled
                }"
                    class="flex justify-between items-center h-16 px-6 transition-all duration-500 rounded-2xl border">

                    <div class="flex-shrink-0 flex items-center gap-3 group cursor-pointer">
                        <div class="relative w-9 h-9 flex items-center justify-center">
                            <div
                                class="absolute inset-0 bg-indigo-600 rounded-xl rotate-6 group-hover:rotate-12 transition-transform duration-300 opacity-20">
                            </div>
                            <div
                                class="relative w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-500/30">
                                <span class="text-base tracking-tighter">CP</span>
                            </div>
                        </div>
                        <a href="{{ route('welcome') }}" wire:navigate
                            class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">
                            Client<span
                                class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-500">Pivot</span>
                        </a>
                    </div>

                    <div class="hidden md:flex items-center space-x-1">
                        <a href="#features"
                            class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-white transition-all rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            Features
                        </a>
                        <a href="{{ route('about') }}" wire:navigate
                            class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-white transition-all rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            About
                        </a>
                        @if (Route::has('freelancers'))
                            <a href="{{ route('freelancers') }}" wire:navigate
                                class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-white transition-all rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                Freelancers
                            </a>
                        @endif
                        <a href="{{ route('pricing') }}" wire:navigate
                            class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-white transition-all rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            Pricing
                        </a>
                    </div>

                    <div class="hidden md:flex items-center gap-6">
                        <a href="{{ route('login') }}"
                            class="text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors">
                            Sign in
                        </a>
                        <a href="{{ route('login') }}" wire:navigate
                            class="relative group overflow-hidden px-6 py-2.5 text-sm font-semibold text-white transition-all duration-300 bg-slate-900 dark:bg-indigo-600 rounded-xl hover:shadow-[0_0_20px_rgba(79,70,229,0.4)] active:scale-95">
                            <span class="relative z-10 flex items-center gap-2">
                                Get Started
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                            <div
                                class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 bg-gradient-to-r from-transparent via-white/20 to-transparent">
                            </div>
                        </a>
                    </div>

                    <div class="flex md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="p-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="mobileMenuOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                class="absolute top-full left-0 w-full px-4 mt-2 md:hidden">
                <div
                    class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-2xl p-4 overflow-hidden">
                    <div class="grid gap-2">
                        <a href="#features"
                            class="flex items-center px-4 py-3 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 transition-all">
                            Features
                        </a>
                        <a href="{{ route('pricing') }}"
                            class="flex items-center px-4 py-3 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 transition-all">
                            Pricing
                        </a>
                        <div class="my-2 border-t border-slate-100 dark:border-slate-800"></div>
                        <a href="{{ route('login') }}"
                            class="flex items-center justify-center w-full px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold shadow-lg shadow-indigo-500/30">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
        </nav>


        <div class="">
            {{ $slot }}
        </div>


        <footer
            class="relative bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 pt-20 pb-10 transition-colors duration-300 overflow-hidden">
            <div
                class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-px bg-gradient-to-r from-transparent via-indigo-500/20 to-transparent">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-12 gap-12 mb-16">

                    <div class="col-span-2 lg:col-span-4">
                        <div class="flex items-center gap-3 mb-6 group cursor-pointer">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-500/20 group-hover:rotate-6 transition-transform">
                                C
                            </div>
                            <span class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                                Client<span
                                    class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-400">Pivot</span>
                            </span>
                        </div>

                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-8 leading-relaxed max-w-xs">
                            The intelligence layer for modern freelancers. Automate your workflow, stabilize your income,
                            and scale your client relationships.
                        </p>

                        <div class="space-y-3">
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">Join
                                the Newsletter</p>
                            <form class="flex max-w-sm">
                                <input type="email" placeholder="work@email.com"
                                    class="flex-1 px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-l-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none">
                                <button
                                    class="px-5 py-2.5 bg-slate-900 dark:bg-indigo-600 text-white text-sm font-bold rounded-r-xl hover:bg-indigo-700 transition-all active:scale-95">
                                    Join
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-[0.2em] mb-6">
                            Product</h3>
                        <ul class="space-y-4">
                            <li><a href="#"
                                    class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Features</a>
                            </li>
                            <li class="flex items-center gap-2">
                                <a href="#"
                                    class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">WhatsApp
                                    API</a>
                                <span
                                    class="text-[9px] font-bold bg-indigo-100 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 px-2 py-0.5 rounded-full">BETA</span>
                            </li>
                            <li><a href="{{ route('pricing') }}"
                                    class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Pricing</a>
                            </li>
                            <li><a href="#"
                                    class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Changelog</a>
                            </li>
                        </ul>
                    </div>

                    <div class="lg:col-span-2">
                        <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-[0.2em] mb-6">
                            Resources</h3>
                        <ul class="space-y-4">
                            <li><a href="#"
                                    class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Documentation</a>
                            </li>
                            <li><a href="#"
                                    class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Community</a>
                            </li>
                            <li><a href="#"
                                    class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Help
                                    Center</a></li>
                        </ul>
                    </div>

                    <div class="lg:col-span-2">
                        <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-[0.2em] mb-6">Legal
                        </h3>
                        <ul class="space-y-4">
                            <li><a href="#"
                                    class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Privacy
                                    Policy</a></li>
                            <li><a href="#"
                                    class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Terms
                                    of Service</a></li>
                            <li><a href="#"
                                    class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Security</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="pt-8 border-t border-slate-200 dark:border-slate-800/60 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <p class="text-xs font-medium text-slate-400 dark:text-slate-500">
                            &copy; 2026 Client Pivot Inc.
                        </p>

                        <div
                            class="flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span
                                class="text-[10px] font-bold text-slate-600 dark:text-slate-300 uppercase tracking-tight">Systems
                                Operational</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <a href="#"
                            class="text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-all hover:scale-110">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#"
                            class="text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-all hover:scale-110">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    @endguest

    @auth('web')
        <div class="flex flex-col lg:flex-row min-h-screen dark:bg-neutral-900">
            <flux:sidebar sticky collapsible="mobile"
                class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
                <flux:sidebar.header>
                    <flux:sidebar.brand href="{{ route('dashboard') }}"
                        logo="{{ asset('uploads/clientpivot-logo-cropped.png') }}" name="ClientPivot" />
                    <flux:sidebar.collapse
                        class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
                </flux:sidebar.header>
                <flux:sidebar.nav>
                    <flux:sidebar.item icon="home" href="{{ route('dashboard') }}" wire:navigate
                        :current="request()->routeIs('dashboard')">Dashboard
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="users" href="{{ route('clients') }}" wire:navigate
                        :current="request()->routeIs('clients')">Clients
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="document-text" href="{{ route('projects') }}" wire:navigate
                        :current="request()->routeIs('projects')">Projects</flux:sidebar.item>
                    <flux:sidebar.item icon="document-currency-dollar" href="{{ route('invoices') }}" wire:navigate
                        :current="request()->routeIs('invoices.*')">Invoices
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="cog" href="#" wire:navigate
                        :current="request()->routeIs('aibyok')">
                        AI (BYOK)</flux:sidebar.item>
                    <flux:sidebar.item icon="clock" href="#" wire:navigate
                        :current="request()->routeIs('timetrack')">Time Tracking</flux:sidebar.item>
                    <flux:sidebar.item icon="credit-card" href="#" wire:navigate
                        :current="request()->routeIs('payments')">Payments & Gateways
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="document" href="#" wire:navigate
                        :current="request()->routeIs('proposals')">Proposals</flux:sidebar.item>
                    {{-- <flux:sidebar.group expandable icon="star" heading="Favorites" class="grid">
                        <flux:sidebar.item href="#">Marketing site</flux:sidebar.item>
                        <flux:sidebar.item href="#">Android app</flux:sidebar.item>
                        <flux:sidebar.item href="#">Brand guidelines</flux:sidebar.item>
                    </flux:sidebar.group> --}}
                </flux:sidebar.nav>
                <flux:sidebar.spacer />
                <flux:sidebar.nav>
                    <flux:sidebar.item icon="cog-6-tooth" href="{{ route('settings') }}" wire:navigate
                        :current="request()->routeIs('settings')">Settings
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="information-circle" href="#" wire:navigate
                        :current="request()->routeIs('help')">Help</flux:sidebar.item>
                </flux:sidebar.nav>
                <flux:dropdown position="top" align="start" class="max-lg:hidden">
                    <flux:sidebar.profile
                        :avatar="Auth::guard('web')->user()->profile_pic ? asset('uploads/' . Auth::guard('web')->user()->profile_pic) : null"
                        name="{{ Str::title(Auth::guard('web')->user()->name) }}" />
                    <flux:menu
                        class="min-w-[240px] !p-0 overflow-hidden bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl shadow-xl shadow-neutral-900/5 ring-1 ring-neutral-900/5">

                        <div
                            class="px-4 py-3 border-b border-neutral-100 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-800/50">
                            <p class="text-sm font-semibold text-neutral-900 dark:text-white truncate">
                                {{ Str::title(Auth::guard('web')->user()->name) }}
                            </p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 truncate mt-0.5 font-medium">
                                {{ Auth::guard('web')->user()->email }}
                            </p>
                        </div>

                        <div class="p-1.5">
                            <flux:modal.trigger name="signout">
                                <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
                            </flux:modal.trigger>
                        </div>
                    </flux:menu>
                </flux:dropdown>
            </flux:sidebar>
            <flux:header class="lg:hidden">
                <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
                <flux:spacer />
                <flux:dropdown position="top" align="start">
                    <flux:profile :chevron="false" circle
                        :avatar="Auth::guard('web')->user()->profile_pic ? asset('uploads/' . Auth::guard('web')->user()->profile_pic) : null" />
                    <flux:menu>
                        <flux:menu.radio.group>
                            <flux:menu.radio>{{ Str::title(Auth::guard('web')->user()->name) }}
                            </flux:menu.radio>
                        </flux:menu.radio.group>
                        <flux:menu.separator />
                        <flux:menu.item icon="arrow-right-start-on-rectangle">
                            <div class="p-1.5">
                                <flux:modal.trigger name="signout">Logout</flux:modal.trigger>
                            </div>
                        </flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            </flux:header>
            <div class="flex-1 min-w-0 lg:p-5 mt-8">
                <div class="w-full overflow-x-auto">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <footer
            class="bg-slate-50 dark:bg-neutral-900 border-t border-neutral-200 dark:border-neutral-800/50 py-6 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">

                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-x-6 gap-y-2">
                        <div
                            class="flex items-center gap-2 opacity-80 grayscale hover:grayscale-0 transition-all duration-300">
                            <div
                                class="w-6 h-6 rounded-md bg-neutral-800 dark:bg-white flex items-center justify-center text-[10px] font-bold text-white dark:text-neutral-900">
                                CP
                            </div>
                            <span
                                class="text-xs font-bold tracking-tight text-neutral-900 dark:text-white uppercase">ClientPivot</span>
                        </div>
                        <p class="text-[11px] font-medium text-neutral-400 dark:text-neutral-500 tracking-tight">
                            &copy; 2026 Internal Ops. All rights reserved.
                        </p>
                        <div class="hidden sm:block h-3 w-px bg-neutral-200 dark:bg-neutral-700"></div>
                        <a href="#"
                            class="text-[11px] font-bold text-neutral-500 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white transition-colors uppercase tracking-wider">Privacy
                            Policy</a>
                        <a href="#"
                            class="text-[11px] font-bold text-neutral-500 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white transition-colors uppercase tracking-wider">Terms</a>
                    </div>

                    <div class="flex items-center gap-4">
                        <div
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                            <span class="relative flex h-1.5 w-1.5">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                            </span>
                            <span
                                class="text-[10px] font-bold text-neutral-600 dark:text-neutral-300 uppercase tracking-tighter">API:
                                Stable</span>
                        </div>

                        <button
                            class="flex items-center gap-2 px-4 py-1.5 text-[11px] font-bold text-neutral-600 dark:text-neutral-300 hover:text-neutral-900 dark:hover:text-white bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg transition-all active:scale-95 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Help & Support
                        </button>
                    </div>

                </div>
            </div>
        </footer>

        {{-- flux signout modal --}}
        <flux:modal name="signout" class="md:w-96">
            <div class="text-center">
                <flux:heading size="lg">Sign Out</flux:heading>
                <flux:text class="mt-2">
                    Are you sure you want to sign out? <br>You will need to log in again to continue.
                </flux:text>
            </div>

            <div class="flex gap-3 mt-4">
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <x-danger-button type="submit" class="w-full justify-center text-center">
                        SIGN OUT
                    </x-danger-button>
                </form>

                <flux:modal.close class="flex-1">
                    <x-primary-button variant="ghost" class="w-full justify-center text-center">
                        CANCEL
                    </x-primary-button>
                </flux:modal.close>
            </div>
        </flux:modal>
    @endauth




    {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.0/dist/flowbite.min.js"></script> --}}

    @livewireScripts
    @fluxScripts

</body>

</html>
