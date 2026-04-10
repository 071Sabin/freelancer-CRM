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
    <meta name="color-scheme" content="dark light">

    <meta property="og:title" content="Client Pivot - Intelligent Client Management for Freelancers">

    <script>
        (function() {
            const stored = localStorage.getItem('theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (stored === 'dark' || (!stored && systemDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    @livewireStyles
    @filamentStyles
    @fluxAppearance

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @vite('resources/css/app.css') --}}

    <style>
        html {
            scroll-behavior: smooth;
            color-scheme: light dark;
        }
    </style>

</head>

<body class="bg-white dark:bg-neutral-900">
    {{-- Navigation --}}
    @guest('web')
        <nav x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = window.pageYOffset > 20" class="fixed top-0 w-full z-50"
            :class="scrolled
                ?
                'bg-white/70 dark:bg-slate-900/70 backdrop-blur-lg shadow-sm' :
                'bg-white dark:bg-slate-950'">

            <div class="max-w-7xl mx-auto px-6">
                <div class="flex items-center justify-between h-16">

                    {{-- Logo --}}
                    <a href="{{ route('welcome') }}" wire:navigate
                        class="flex items-center gap-3 font-semibold text-slate-900 dark:text-white">

                        <div
                            class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white text-sm font-bold">
                            CP
                        </div>

                        <span class="text-lg tracking-tight">
                            Client<span class="text-indigo-600 dark:text-indigo-400">Pivot</span>
                        </span>
                    </a>

                    {{-- Desktop Nav --}}
                    <div class="hidden md:flex items-center gap-8 text-sm font-medium">

                        <a href="#features"
                            class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-white">
                            Features
                        </a>

                        <a href="{{ route('about') }}" wire:navigate
                            class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-white">
                            About
                        </a>

                        <a href="{{ route('pricing') }}" wire:navigate
                            class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-white">
                            Pricing
                        </a>

                    </div>

                    {{-- Right --}}
                    <div class="hidden md:flex items-center gap-6 text-sm">

                        <a href="{{ route('login') }}" wire:navigate
                            class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white">
                            Sign in
                        </a>

                        <a href="{{ route('login') }}" wire:navigate
                            class="px-5 py-2 rounded-lg bg-slate-900 dark:bg-indigo-600 text-white font-semibold">
                            Get Started
                        </a>
                        <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle"
                            aria-label="Toggle dark mode" />
                    </div>

                    {{-- Mobile Button --}}
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-slate-600 dark:text-slate-300">
                        ☰
                    </button>

                </div>
            </div>

            {{-- Mobile Dropdown --}}
            <div x-show="mobileMenuOpen" x-cloak
                class="md:hidden bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">

                <div class="px-6 py-4 space-y-4 text-sm">
                    <a href="#features" class="block text-slate-600 dark:text-slate-300">Features</a>
                    <a href="{{ route('pricing') }}" class="block text-slate-600 dark:text-slate-300">Pricing</a>
                    <a href="{{ route('login') }}" class="block font-semibold text-indigo-600 dark:text-indigo-400">
                        Get Started
                    </a>
                </div>
                <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle"
                    aria-label="Toggle dark mode" />
            </div>

        </nav>

        <div class="pt-16">
            {{ $slot }}
        </div>

        <footer class="relative mt-20 border-t border-zinc-200 bg-white pt-16 pb-8 dark:border-zinc-800 dark:bg-zinc-950">
            <div
                class="absolute inset-x-0 -top-px -z-10 h-px w-full bg-gradient-to-r from-transparent via-indigo-500/50 to-transparent">
            </div>

            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                    <div class="space-y-6">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="h-8 w-8 rounded-lg bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                                <span class="text-white font-bold text-lg leading-none">C</span>
                            </div>
                            <span
                                class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white font-pricing">ClientPivot</span>
                        </div>
                        <p class="max-w-xs text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                            Intelligent client management for modern freelancers. Scale your business, not your overhead.
                        </p>
                        <div class="flex items-center gap-2 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            Systems Operational
                        </div>
                    </div>

                    <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
                        <div class="md:grid md:grid-cols-2 md:gap-8">
                            <div>
                                <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-900 dark:text-zinc-100">
                                    Product</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li><a href="#"
                                            class="text-sm text-zinc-500 transition-colors hover:text-indigo-600 dark:text-zinc-400 dark:hover:text-indigo-400">Features</a>
                                    </li>
                                    <li><a href="{{ route('pricing') }}"
                                            class="text-sm text-zinc-500 transition-colors hover:text-indigo-600 dark:text-zinc-400 dark:hover:text-indigo-400">Pricing</a>
                                    </li>
                                    <li><a href="#"
                                            class="text-sm text-zinc-500 transition-colors hover:text-indigo-600 dark:text-zinc-400 dark:hover:text-indigo-400">Changelog</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-10 md:mt-0">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-900 dark:text-zinc-100">
                                    Resources</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li><a href="#"
                                            class="text-sm text-zinc-500 transition-colors hover:text-indigo-600 dark:text-zinc-400 dark:hover:text-indigo-400">Documentation</a>
                                    </li>
                                    <li><a href="#"
                                            class="text-sm text-zinc-500 transition-colors hover:text-indigo-600 dark:text-zinc-400 dark:hover:text-indigo-400">Support</a>
                                    </li>
                                    <li><a href="#"
                                            class="text-sm text-zinc-500 transition-colors hover:text-indigo-600 dark:text-zinc-400 dark:hover:text-indigo-400">API
                                            Reference</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="md:grid md:grid-cols-2 md:gap-8">
                            <div>
                                <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-900 dark:text-zinc-100">
                                    Legal</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li><a href="#"
                                            class="text-sm text-zinc-500 transition-colors hover:text-indigo-600 dark:text-zinc-400 dark:hover:text-indigo-400">Privacy
                                            Policy</a></li>
                                    <li><a href="#"
                                            class="text-sm text-zinc-500 transition-colors hover:text-indigo-600 dark:text-zinc-400 dark:hover:text-indigo-400">Terms
                                            of Service</a></li>
                                </ul>
                            </div>
                            <div class="mt-10 md:mt-0">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-900 dark:text-zinc-100">
                                    Social</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li><a href="#"
                                            class="text-sm text-zinc-500 transition-colors hover:text-indigo-600 dark:text-zinc-400 dark:hover:text-indigo-400">X
                                            (Twitter)</a></li>
                                    <li><a href="#"
                                            class="text-sm text-zinc-500 transition-colors hover:text-indigo-600 dark:text-zinc-400 dark:hover:text-indigo-400">LinkedIn</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-16 border-t border-zinc-100 pt-8 dark:border-zinc-800/60 flex flex-col md:flex-row items-center justify-between gap-6">
                    <p class="text-xs text-zinc-400 dark:text-zinc-500">
                        &copy; 2026 ClientPivot. Built for those who build.
                    </p>

                    <div class="flex items-center gap-6">
                        <span
                            class="text-[10px] font-bold text-zinc-300 dark:text-zinc-700 uppercase tracking-widest">Global
                            Node: Ashburn, VA</span>
                    </div>
                </div>
            </div>
        </footer>
    @endguest

    @auth('web')
        @php
            $user = auth()->user();
            $isPro = $user->subscription && $user->subscription->status === 'active';
        @endphp
        <div class="flex flex-col lg:flex-row min-h-screen dark:bg-neutral-900">
            <flux:sidebar sticky collapsible
                class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700 text-neutral-800 dark:text-neutral-200">
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
                        :current="request()->routeIs('clients') || request()->routeIs('clients.*')">Clients
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="document-text" href="{{ route('projects') }}" wire:navigate
                        :current="request()->routeIs('projects') || request()->routeIs('projects.*')">Projects
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="document-currency-dollar" href="{{ route('invoices') }}" wire:navigate
                        :current="request()->routeIs('invoices') || request()->routeIs('invoices.*')">Invoices
                    </flux:sidebar.item>
                    <flux:sidebar.group expandable icon="cog" heading="Client Automations" class="grid"
                        :current="request()->routeIs('aibyok')">
                        <flux:sidebar.item href="#">Marketing site</flux:sidebar.item>
                        <flux:sidebar.item href="#">Android app</flux:sidebar.item>
                        <flux:sidebar.item href="#">Brand guidelines</flux:sidebar.item>
                    </flux:sidebar.group>
                    <flux:sidebar.item icon="clock" href="#" wire:navigate
                        :current="request()->routeIs('timetrack')">Time Tracking</flux:sidebar.item>
                    <flux:sidebar.item icon="credit-card" href="#" wire:navigate
                        :current="request()->routeIs('payments')">Payments & Gateways
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="document" href="#" wire:navigate
                        :current="request()->routeIs('proposals')">Proposals</flux:sidebar.item>

                    {{-- <flux:sidebar.item>
                        @if (auth()->user()->subscription && auth()->user()->subscription->status === 'active')
                            <span class="bg-green-100 text-green-800 w-full px-3 rounded-l py-2">Pro Member</span>
                        @else
                            <button wire:click="upgrade">Upgrade Now</button>
                        @endif
                    </flux:sidebar.item> --}}
                    {{-- <flux:sidebar.group expandable icon="star" heading="Favorites" class="grid">
                        <flux:sidebar.item href="#">Marketing site</flux:sidebar.item>
                        <flux:sidebar.item href="#">Android app</flux:sidebar.item>
                        <flux:sidebar.item href="#">Brand guidelines</flux:sidebar.item>
                    </flux:sidebar.group> --}}
                </flux:sidebar.nav>


                @if (auth()->user()->isOnTrial())
                    {{-- <button wire:click="upgrade">Upgrade Now</button> --}}
                    <div x-data x-show="!$store.sidebar?.collapsed" x-transition.opacity.duration.200ms
                        class="hidden lg:block">
                        <div class="group relative overflow-hidden rounded-2xl p-[1px] transition-all duration-300">

                            <!-- Outer gradient border -->
                            <div
                                class="absolute inset-0 rounded-2xl bg-gradient-to-br from-purple-500 via-pink-500 to-blue-500 opacity-70 blur-[6px] group-hover:opacity-100 transition">
                            </div>

                            <!-- Main card -->
                            <div class="relative rounded-2xl bg-white/80 p-3 backdrop-blur-xl dark:bg-[#0f1115]/90">

                                <!-- Inner light -->
                                <div
                                    class="pointer-events-none absolute inset-0 rounded-2xl bg-gradient-to-br from-white/40 via-transparent to-transparent opacity-40 dark:from-white/5">
                                </div>

                                <div class="relative space-y-3">

                                    <!-- TOP -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">

                                            <!-- Icon -->
                                            <div
                                                class="relative flex h-6 w-6 items-center justify-center rounded-lg bg-gradient-to-br from-purple-500/20 to-pink-500/10 text-purple-500">

                                                <!-- glow -->
                                                <div
                                                    class="absolute inset-0 rounded-lg bg-purple-400/20 blur-md opacity-60">
                                                </div>

                                                <svg class="relative h-3.5 w-3.5" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                                </svg>
                                            </div>

                                            <!-- Text -->
                                            <span
                                                class="text-xs font-semibold tracking-wide text-slate-700 dark:text-slate-200">
                                                Upgrade to Pro
                                            </span>
                                        </div>

                                        <!-- Settings -->
                                        <button
                                            class="rounded-md p-1 text-slate-400 transition hover:bg-black/5 hover:text-slate-700 dark:hover:bg-white/10 dark:hover:text-white">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0..." />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- VALUE TEXT -->
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                        Unlock premium features, faster performance, and priority access.
                                    </p>

                                    <!-- CTA -->
                                    <button
                                        class="relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-purple-500 via-pink-500 to-blue-500 py-1.5 text-xs font-semibold text-white shadow-md transition-all duration-300 hover:shadow-lg">

                                        <span class="relative z-10">Upgrade Now</span>

                                        <!-- shine animation -->
                                        <div
                                            class="absolute inset-0 translate-x-[-100%] bg-gradient-to-r from-transparent via-white/40 to-transparent transition-transform duration-700 group-hover:translate-x-[100%]">
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <flux:sidebar.spacer />
                <flux:sidebar.nav>
                    <flux:sidebar.item icon="cog-6-tooth" href="{{ route('settings') }}" wire:navigate
                        :current="request()->routeIs('settings')">Settings
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="information-circle" href="#" wire:navigate
                        :current="request()->routeIs('help')">Help</flux:sidebar.item>
                    <flux:dropdown x-data align="end">
                        <flux:button variant="subtle" square class="group" aria-label="Preferred color scheme">
                            <flux:icon.sun x-show="$flux.appearance === 'light'" variant="mini"
                                class="text-zinc-500 dark:text-white" />
                            <flux:icon.moon x-show="$flux.appearance === 'dark'" variant="mini"
                                class="text-zinc-500 dark:text-white" />
                            <flux:icon.moon x-show="$flux.appearance === 'system' && $flux.dark" variant="mini" />
                            <flux:icon.sun x-show="$flux.appearance === 'system' && ! $flux.dark" variant="mini" />
                        </flux:button>

                        <flux:menu>
                            <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Light</flux:menu.item>
                            <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Dark</flux:menu.item>
                            <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">System
                            </flux:menu.item>
                        </flux:menu>

                    </flux:dropdown>
                </flux:sidebar.nav>
                <flux:dropdown position="top" align="start" class="max-lg:hidden">

                    <flux:sidebar.profile
                        class="{{ $isPro ? 'ring-2 ring-purple-500/70 bg-purple-100/50 dark:bg-purple-500/20 ring-offset-2 ring-offset-white dark:ring-offset-[#0f1115] shadow-[0_0_12px_rgba(168,85,247,0.45)]' : '' }}"
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
                                <flux:menu.item icon="arrow-right-start-on-rectangle">Sign Out</flux:menu.item>
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
            <div class="flex-1 min-w-0 lg:p-5 px-2 my-8">
                <div class="w-full">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <footer
            class="bg-neutral-50 dark:bg-[#0a0a0a] border-t border-neutral-200/80 dark:border-neutral-800/60 py-8 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-8">

                    <div class="flex flex-col md:flex-row items-center gap-x-8 gap-y-4">
                        <div class="flex items-center gap-2.5 group cursor-default">
                            <div
                                class="w-8 h-8 rounded-lg bg-neutral-900 dark:bg-white flex items-center justify-center text-[12px] font-black text-white dark:text-neutral-900 shadow-sm transition-transform group-hover:scale-105">
                                CP
                            </div>
                            <span
                                class="text-sm md:text-base font-bold tracking-tight text-neutral-900 dark:text-white uppercase">
                                ClientPivot
                            </span>
                        </div>

                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-x-5 gap-y-2">
                            <p
                                class="text-[10px] md:text-[11px] font-semibold text-neutral-500 dark:text-neutral-500 uppercase tracking-widest">
                                &copy; 2026 Internal Ops
                            </p>
                            <div class="hidden md:block h-3 w-px bg-neutral-300 dark:bg-neutral-800"></div>
                            <a href="#"
                                class="text-[11px] font-bold text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white transition-colors uppercase tracking-wider">
                                Privacy
                            </a>
                            <a href="#"
                                class="text-[11px] font-bold text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white transition-colors uppercase tracking-wider">
                                Terms
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                        <div
                            class="flex items-center gap-2.5 px-4 py-2 rounded-full bg-white dark:bg-neutral-900/50 border border-neutral-200 dark:border-neutral-800 shadow-[0_1px_2px_rgba(0,0,0,0,05)]">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span
                                class="text-[10px] md:text-[11px] font-bold text-neutral-700 dark:text-neutral-300 uppercase tracking-tighter">
                                Systems: <span class="text-emerald-600 dark:text-emerald-400">Operational</span>
                            </span>
                        </div>

                        <button
                            class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-2 text-[11px] font-bold text-neutral-700 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-full transition-all active:scale-95 shadow-sm hover:shadow-md">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Support Center
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

    {{-- <livewire:projects-table /> --}}

    @livewireScripts
    @filamentScripts
    @fluxScripts

    <script>
        window.addEventListener('scroll-to-error', () => {
            const firstError = document.querySelector('.text-red-600'); // Or whatever your error class is
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    </script>

</body>

</html>
