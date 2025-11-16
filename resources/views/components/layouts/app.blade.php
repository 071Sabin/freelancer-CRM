<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'ClientPivot') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" /> --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @livewireStyles

    <style>
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

<body class="bg-white dark:stone-800">
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
        <nav class="fixed top-0 z-50 w-full bg-stone-100">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start rtl:justify-end">
                        <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar"
                            aria-controls="top-bar-sidebar" type="button"
                            class="sm:hidden text-heading bg-transparent box-border border border-transparent font-medium leading-5 rounded-base text-sm focus:outline-none">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="M5 7h14M5 12h14M5 17h10" />
                            </svg>
                        </button>
                        <a href="https://flowbite.com" class="flex ms-2 md:me-24">
                            <span
                                class="self-center text-lg font-bold ml-5 whitespace-nowrap dark:text-white">ClientPivot</span>
                        </a>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center ms-3">
                            <div>
                                <button type="button"
                                    class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                    aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="w-8 h-8 rounded-full"
                                        src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                        alt="user photo">
                                </button>
                            </div>
                            <div class="z-50 hidden bg-gray-50 rounded-base shadow-lg w-44" id="dropdown-user">
                                <div class="px-4 py-3 border-b border-stone-200" role="none">
                                    <p class="text-sm font-medium text-heading" role="none">
                                        {{ Auth::guard('freelancers')->user()->name }}
                                    </p>
                                    <p class="text-sm text-body truncate" role="none">
                                        {{ Auth::guard('freelancers')->user()->email }}
                                    </p>
                                </div>
                                <ul class="p-2 text-sm text-body font-medium" role="none">
                                    <li>
                                        <a href="{{ route('dashboard') }}"
                                            class="inline-flex items-center w-full p-2 hover:bg-stone-200 hover:rounded-medium hover:text-heading rounded"
                                            role="menuitem">Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="inline-flex items-center w-full p-2 hover:bg-stone-200 hover:rounded-medium hover:text-heading rounded"
                                            role="menuitem">Settings</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="inline-flex items-center w-full p-2 hover:bg-stone-200 hover:rounded-medium hover:text-heading rounded"
                                            role="menuitem">Earnings</a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="openSignoutModal(event)"
                                            class="inline-flex items-center w-full p-2 hover:bg-stone-200 hover:rounded-medium hover:text-heading rounded">
                                            Sign out
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <aside id="top-bar-sidebar"
            class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0"
            aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto bg-stone-100">
                <a href="https://flowbite.com/" class="flex items-center ps-2.5 mb-5">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 me-3" alt="Flowbite Logo" />
                    <span class="self-center text-lg text-heading font-semibold whitespace-nowrap">Flowbite</span>
                </a>
                <ul class="space-y-4 font-medium mt-5">

                    {{-- PRIMARY --}}
                    <li>
                        <a href="{{ route('dashboard') }}" wire:navigate
                            class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-stone-200 hover:rounded hover:text-fg-brand group">
                            <i class="bi bi-speedometer2 me-3" aria-hidden="true"></i>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>

                    {{-- CRM / Client Manager (MVP) --}}
                    <li>
                        <a href="#" wire:navigate
                            class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-stone-200 hover:rounded hover:text-fg-brand group">
                            <i class="bi bi-people me-3" aria-hidden="true"></i>
                            <div class="flex-1">
                                <span class="ms-3">Clients</span>
                            </div>
                        </a>
                    </li>

                    {{-- Project Manager (MVP) --}}
                    <li>
                        <a href="#" wire:navigate
                            class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-stone-200 hover:rounded hover:text-fg-brand group">
                            <i class="bi bi-kanban me-3" aria-hidden="true"></i>
                            <div class="flex-1">
                                <span class="ms-3">Projects</span>
                            </div>
                        </a>
                    </li>

                    {{-- Invoice & Payment Manager (MVP) --}}
                    <li>
                        <a href="#" wire:navigate
                            class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-stone-200 hover:rounded hover:text-fg-brand group">
                            <i class="bi bi-receipt me-3" aria-hidden="true"></i>
                            <div class="flex-1">
                                <span class="ms-3">Invoices</span>
                            </div>
                        </a>
                    </li>

                    {{-- AI & BYOK (Phase 2 / Magic) --}}
                    <li>
                        <a href="#" wire:navigate
                            class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-stone-200 hover:rounded hover:text-fg-brand group">
                            <i class="bi bi-brightness-high me-3" aria-hidden="true"></i>
                            <div class="flex-1">
                                <span class="ms-3">AI (BYOK)</span>
                            </div>
                        </a>
                    </li>

                    {{-- Time & Billing / Advanced (Phase 2) --}}
                    <li>
                        <a href="#" wire:navigate
                            class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-stone-200 hover:rounded hover:text-fg-brand group">
                            <i class="bi bi-clock-history me-3" aria-hidden="true"></i>
                            <div class="flex-1">
                                <span class="ms-3">Time Tracking</span>
                            </div>
                        </a>
                    </li>

                    {{-- Payments / Integrations --}}
                    <li>
                        <a href="#" wire:navigate
                            class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-stone-200 hover:rounded hover:text-fg-brand group">
                            <i class="bi bi-credit-card-2-back me-3" aria-hidden="true"></i>
                            <div class="flex-1">
                                <span class="ms-3">Payments & Gateways</span>
                            </div>
                        </a>
                    </li>

                    {{-- Proposals (Phase 2) --}}
                    <li>
                        <a href="#" wire:navigate
                            class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-stone-200 hover:rounded hover:text-fg-brand group">
                            <i class="bi bi-file-earmark-text me-3" aria-hidden="true"></i>
                            <div class="flex-1">
                                <span class="ms-3">Proposals</span>
                            </div>
                        </a>
                    </li>

                    {{-- Utilities --}}
                    <li>
                        <a href="#" wire:navigate
                            class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-stone-200 hover:rounded hover:text-fg-brand group">
                            <i class="bi bi-gear me-3" aria-hidden="true"></i>
                            <span class="ms-3">Settings</span>
                        </a>
                    </li>

                    {{-- Inbox / Notifications (example) --}}
                    <li>
                        <a href="#" wire:navigate
                            class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-stone-200 hover:rounded hover:text-fg-brand group">
                            <i class="bi bi-inbox me-3" aria-hidden="true"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Inbox</span>
                            <span
                                class="inline-flex items-center justify-center w-4.5 h-4.5 ms-2 text-xs font-medium text-fg-danger-strong bg-danger-soft border border-danger-subtle rounded-full">2</span>
                        </a>
                    </li>

                    {{-- Static pages / users --}}
                    <li>
                        <a href="#" wire:navigate
                            class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-stone-200 hover:rounded hover:text-fg-brand group">
                            <i class="bi bi-people-fill me-3" aria-hidden="true"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                        </a>
                    </li>

                    {{-- Sign out (opens your modal) --}}
                    <li>
                        <a href="#" onclick="openSignoutModal(event)"
                            class="inline-flex items-center w-full p-2 hover:bg-stone-200 hover:rounded-medium hover:text-heading rounded">
                            <i class="bi bi-box-arrow-right me-3" aria-hidden="true"></i>
                            <span class="ms-3">Sign out</span>
                        </a>
                    </li>

                </ul>

            </div>
        </aside>

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



        <div class="p-4 sm:ml-64 mt-14">
            <div class="p-4 rounded-base bg-stone-100 rounded-md">
                <div class="gap-4 mb-4">
                    {{ $slot }}
                </div>

            </div>
        </div>
    @endif





    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.0/dist/flowbite.min.js"></script>
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
</body>

</html>
