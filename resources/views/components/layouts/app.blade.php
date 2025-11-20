<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'ClientPivot') }}</title>

    <!-- Fonts -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    @livewireStyles
    @fluxAppearance

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
    @if (Auth::guard('freelancers')->check() !== true)
        <nav
            class="w-full px-10 flex items-center justify-between mb-8 py-5 shadow-sm 
    bg-white dark:bg-neutral-900 dark:text-neutral-100 transition-colors duration-300">

            <!-- Left Logo -->
            <div class="text-2xl font-bold tracking-tight">
                <a href="{{ route('welcome') }}" wire:navigate
                    class="hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors">
                    ClientPivot
                </a>
            </div>

            <!-- Desktop Links -->
            <ul class="hidden md:flex items-center gap-8 text-lg font-medium">
                <li>
                    <a href="#features" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        Features
                    </a>
                </li>

                <li>
                    <a href="#pricing" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        Pricing
                    </a>
                </li>

                <li>
                    <a href="#about" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        About
                    </a>
                </li>
                <li>
                    <a href="{{ route('register') }}"
                        class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors" wire:navigate>
                        Register
                    </a>
                </li>
            </ul>

            <!-- Mobile Menu Button -->
            <button
                class="md:hidden p-2 rounded-xl border 
        border-neutral-300 dark:border-neutral-700
        hover:bg-neutral-100 dark:hover:bg-neutral-800 
        transition-colors duration-300">
                ☰
            </button>
        </nav>
        <div class="w-full mx-auto flex items-center justify-center">
            {{ $slot }}
        </div>
    @elseif (Auth::guard('freelancers')->check() === true)
        <div class="flex flex-col lg:flex-row min-h-screen dark:bg-neutral-900">
            <flux:sidebar sticky collapsible
                class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
                <flux:sidebar.header>
                    <flux:sidebar.brand href="#" logo="https://fluxui.dev/img/demo/logo.png"
                        logo:dark="https://fluxui.dev/img/demo/dark-mode-logo.png" name="ClientPivot" />
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
                    <flux:sidebar.item icon="document-text" href="#" wire:navigate
                        :current="request()->routeIs('projects')">Projects</flux:sidebar.item>
                    <flux:sidebar.item icon="document-currency-dollar" href="#" wire:navigate
                        :current="request()->routeIs('invoices')">Invoices
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="cog" href="#" wire:navigate
                        :current="request()->routeIs('aibyok')">AI (BYOK)</flux:sidebar.item>
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
                    <flux:sidebar.profile avatar="https://fluxui.dev/img/demo/user.png"
                        name="{{ Str::title(Auth::guard('freelancers')->user()->name) }}" />
                    <flux:menu>
                        <flux:menu.radio.group>
                            <flux:menu.radio checked>{{ Str::title(Auth::guard('freelancers')->user()->name) }}
                            </flux:menu.radio>
                            <p class="text-sm font-thin text-stone-400">
                                {{ Auth::guard('freelancers')->user()->email }}</p>
                        </flux:menu.radio.group>
                        <flux:menu.separator />
                        <flux:menu.item icon="arrow-right-start-on-rectangle">
                            <a href="#" onclick="openSignoutModal(event)"
                                class="inline-flex items-center w-full p-2 rounded">
                                <span class="">Sign out</span>
                            </a>
                        </flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            </flux:sidebar>
            <flux:header class="lg:hidden">
                <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
                <flux:spacer />
                <flux:dropdown position="top" align="start">
                    <i class="bi bi-person-circle text-2xl"></i>
                    <flux:menu>
                        <flux:menu.radio.group>
                            <flux:menu.radio checked>{{ Str::title(Auth::guard('freelancers')->user()->name) }}
                            </flux:menu.radio>
                        </flux:menu.radio.group>
                        <flux:menu.separator />
                        <flux:menu.item icon="arrow-right-start-on-rectangle">
                            <a href="#" onclick="openSignoutModal(event)"
                                class="inline-flex items-center w-full p-2 rounded">
                                <span class="">Sign out</span>
                            </a>
                        </flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            </flux:header>
            <div class="w-full lg:m-10 p-3">
                {{ $slot }}
            </div>

        </div>



        <!-- SIGNOUT MODAL -->
        <div id="signoutModal" class="fixed inset-0 hidden items-center justify-center z-[9999]">

            <!-- Blurred Dark/Light Background -->
            <div class="absolute inset-0 bg-black/40 dark:bg-black/60 backdrop-blur-sm" onclick="closeSignoutModal()">
            </div>

            <!-- Modal Box -->
            <div
                class="relative bg-white dark:bg-neutral-900 border border-stone-200 dark:border-stone-700 
                rounded-xl shadow-xl w-full max-w-md mx-4 p-6 flex items-center justify-center flex-col">

                <!-- Title -->
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
                    Confirm Sign Out
                </h2>

                <!-- Description -->
                <p class="text-gray-500 dark:text-gray-400 mb-6">
                    Are you sure you want to sign out? <br>You will need to log in again to continue.
                </p>

                <!-- Buttons -->
                <div class="flex justify-end gap-3">

                    <!-- Cancel -->
                    <button onclick="closeSignoutModal()"
                        class="px-4 py-2 rounded-lg text-sm font-medium
                       bg-stone-200 hover:bg-stone-300 dark:bg-stone-700 dark:hover:bg-stone-600
                       text-stone-800 dark:text-stone-100">
                        Cancel
                    </button>

                    <!-- Sign Out -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 rounded-lg text-sm font-medium
                           bg-red-600 hover:bg-red-700 text-white">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
    {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.0/dist/flowbite.min.js"></script> --}}
    <script>
        function openSignoutModal(e) {
            e.preventDefault();
            document.getElementById('signoutModal').classList.remove('hidden');
            document.getElementById('signoutModal').classList.add('flex');
        }

        function closeSignoutModal() {
            document.getElementById('signoutModal').classList.add('hidden');
            document.getElementById('signoutModal').classList.remove('flex');
        }
    </script>



    @livewireScripts
    @fluxScripts

</body>

</html>
