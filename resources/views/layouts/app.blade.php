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

    <script>
        (function() {
            // 1. Read the theme from LocalStorage
            const theme = localStorage.getItem('theme') || 'system';

            // 2. Check if system is dark
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            // 3. Apply the class immediately
            if (theme === 'dark' || (theme === 'system' && systemDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
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
            :class="{ 'bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm': scrolled, 'bg-transparent': !scrolled }"
            class="fixed top-0 w-full z-50 transition-all duration-300 border-b border-transparent"
            :class="{ 'border-slate-200 dark:border-slate-800': scrolled }">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">

                    <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer">
                        <div
                            class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-600 to-emerald-500 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-indigo-500/20">
                            C
                        </div>
                        <a href="{{ route('welcome') }}" wire:navigate
                            class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                            Client<span class="text-indigo-600 dark:text-indigo-400">Pivot</span>
                        </a>
                    </div>

                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#features"
                            class="text-sm font-medium text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-white transition-colors">
                            Features
                        </a>
                        @if (Route::has('freelancers'))
                            <a href="{{ route('freelancers') }}" wire:navigate
                                class="text-sm font-medium text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-white transition-colors">
                                Freelancers
                            </a>
                        @endif
                        <a href="#pricing" wire:navigate
                            class="text-sm font-medium text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-white transition-colors">
                            Pricing
                        </a>
                        @if (Route::has('about'))
                            <a href="{{ route('about') }}" wire:navigate
                                class="text-sm font-medium text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-white transition-colors">
                                About
                            </a>
                        @endif
                        <div class="h-6 w-px bg-slate-200 dark:bg-slate-700"></div>

                        <a href="{{ route('login') }}" wire:navigate
                            class="group relative inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-slate-900 dark:bg-white dark:text-slate-900 rounded-full hover:bg-indigo-600 dark:hover:bg-indigo-50 dark:hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900">
                            <span>Get Started</span>
                            <svg class="w-4 h-4 ml-1 -mr-1 transition-transform duration-200 group-hover:translate-x-1"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>

                    <div class="flex md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                            class="text-slate-500 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-200 focus:outline-none">
                            <span class="sr-only">Open main menu</span>
                            <svg x-show="!mobileMenuOpen" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="mobileMenuOpen" x-cloak class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2" @click.away="mobileMenuOpen = false"
                class="md:hidden absolute top-20 left-0 w-full bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-xl z-40">

                <div class="px-4 pt-2 pb-6 space-y-2">
                    <a href="#features" @click="mobileMenuOpen = false"
                        class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 dark:text-slate-200 hover:text-indigo-600 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                        Features
                    </a>
                    @if (Route::has('freelancers'))
                        <a href="{{ route('freelancers') }}" wire:navigate
                            class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 dark:text-slate-200 hover:text-indigo-600 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                            Freelancers
                        </a>
                    @endif
                    <a href="#pricing" wire:navigate
                        class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 dark:text-slate-200 hover:text-indigo-600 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                        Pricing
                    </a>
                    @if (Route::has('about'))
                        <a href="#about" wire:navigate
                            class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 dark:text-slate-200 hover:text-indigo-600 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                            About
                        </a>
                    @endif
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800">
                        <a href="{{ route('login') }}" wire:navigate
                            class="block w-full text-center px-6 py-3 rounded-lg text-white font-semibold bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
        </nav>


        <div class="">
            {{ $slot }}
        </div>
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
            <div class="flex-1 min-w-0 lg:m-10 p-3">
                <div class="w-full overflow-x-auto">
                    {{ $slot }}
                </div>
            </div>
        </div>

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

    <footer
        class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 pt-16 pb-8 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 mb-12">

                <div class="col-span-2 lg:col-span-2 pr-8">
                    <div class="flex items-center gap-2 mb-4">
                        <div
                            class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-600 to-emerald-500 flex items-center justify-center text-white font-bold text-lg">
                            C
                        </div>
                        <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                            Client<span class="text-indigo-600 dark:text-indigo-400">Pivot</span>
                        </span>
                    </div>

                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6 leading-relaxed max-w-sm">
                        The operating system for high-growth freelancers. Manage projects, invoices, and WhatsApp client
                        communication in one unified dashboard.
                    </p>

                    <form class="flex flex-col sm:flex-row gap-2">
                        <input type="email" placeholder="Enter your email"
                            class="px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 w-full sm:w-auto transition-all">
                        <button
                            class="px-4 py-2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-semibold rounded-lg hover:bg-indigo-600 dark:hover:bg-indigo-50 dark:hover:text-indigo-700 transition-colors">
                            Subscribe
                        </button>
                    </form>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white uppercase tracking-wider mb-4">
                        Product</h3>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Features</a>
                        </li>
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">WhatsApp
                                API</a> <span
                                class="text-[10px] bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded ml-1">New</span>
                        </li>
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Pricing</a>
                        </li>
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Enterprise</a>
                        </li>
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Changelog</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white uppercase tracking-wider mb-4">
                        Resources</h3>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Documentation</a>
                        </li>
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">API
                                Reference</a></li>
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Community</a>
                        </li>
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Help
                                Center</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white uppercase tracking-wider mb-4">
                        Company</h3>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">About
                                Us</a></li>
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Careers</a>
                        </li>
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Legal</a>
                        </li>
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Contact</a>
                        </li>
                    </ul>
                </div>

                <div class="hidden lg:block">
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white uppercase tracking-wider mb-4">
                        Legal</h3>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Privacy</a>
                        </li>
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Terms</a>
                        </li>
                        <li><a href="#"
                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Security</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-800 my-8"></div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-6">

                <div class="flex flex-col md:flex-row items-center gap-4 md:gap-8">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        &copy; 2024 Client Pivot Inc. All rights reserved.
                    </p>

                    <div
                        class="flex items-center gap-2 px-3 py-1 rounded-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-medium text-slate-600 dark:text-slate-300">All Systems Normal</span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="#"
                        class="text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                    <a href="#"
                        class="text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors">
                        <span class="sr-only">GitHub</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#"
                        class="text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors">
                        <span class="sr-only">LinkedIn</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>


    {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.0/dist/flowbite.min.js"></script> --}}

    @livewireScripts
    @fluxScripts

</body>

</html>
