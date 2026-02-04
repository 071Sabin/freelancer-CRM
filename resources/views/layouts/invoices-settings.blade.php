
@component('layouts.app')
<x-slot:title>ClientPivot | Invoice Settings</x-slot>
    <div class="">

        <x-main-heading title="Invoices" subtitle="Create, send, and track invoices with clear payment status and totals." />


        <flux:breadcrumbs class="mb-5">
            <flux:breadcrumbs.item href="{{route('invoices')}}" wire:navigate>Invoices</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{route('invoices.settings.general')}}" wire:navigate><span class="text-blue-500">Settings</span></flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- Layout --}}
        <div class="flex flex-col lg:flex-row lg:items-start gap-y-3 lg:gap-x-12">

            {{-- Sidebar --}}
            <aside class="w-full lg:w-64 shrink-0 lg:sticky lg:top-6 ">
                    <div class="px-2 pb-3">
                        <flux:heading class="text-xs font-semibold tracking-wider text-zinc-500 uppercase">
                            Invoice Settings
                        </flux:heading>
                    </div>
                <flux:sidebar.nav class="space-y-1 bg-neutral-100 rounded-lg p-3 dark:bg-neutral-800">

                    {{-- Mobile separator --}}
                    <div class="block lg:hidden border-t border-zinc-200 dark:border-zinc-700 mb-3"></div>

                    <flux:sidebar.item href="{{ route('invoices.settings.general') }}" icon="cog-6-tooth" wire:navigate
                        :current="request()->routeIs('invoices.settings.general')">
                        General
                    </flux:sidebar.item>

                    <flux:sidebar.item href="{{ route('invoices.settings.payments') }}" icon="currency-dollar" wire:navigate
                        :current="request()->routeIs('invoices.settings.payments')" disabled>
                        Payments
                    </flux:sidebar.item>

                    <flux:sidebar.item href="{{ route('invoices.settings.branding') }}" icon="paint-brush" wire:navigate
                        :current="request()->routeIs('invoices.settings.branding')" disabled>
                        Branding
                    </flux:sidebar.item>

                </flux:sidebar.nav>
            </aside>
            <flux:separator vertical class="" />
            <flux:separator class="lg:hidden" />


            <flux:main class="flex-1 min-w-0">
                <div class="max-w-4xl space-y-8">
                    {{ $slot }}
                </div>
            </flux:main>

        </div>
    </div>
@endcomponent
