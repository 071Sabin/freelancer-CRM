@component('layouts.app')

    <flux:heading size="xl">Invoice Settings</flux:heading>
    <flux:text class="mb-6 text-neutral-500">
        this is general setting page, all general settings goes here!
    </flux:text>

    <div class="flex w-full p-0">

        <!-- Invoices Sidebar -->
        <flux:sidebar.nav class="">

            <flux:sidebar.item icon="document-text"
                :current="request()->routeIs('invoices.settings.general') && !request()->routeIs('invoices.settings.*')">
                general
            </flux:sidebar.item>

            <flux:sidebar.item icon="cog-6-tooth" :current="request()->routeIs('invoices.settings')">
                Settings
            </flux:sidebar.item>

        </flux:sidebar.nav>

        <flux:separator vertical class="mx-3" />

        <!-- Feature Content -->
        <flux:main>
            {{ $slot }}
        </flux:main>

    </div>
@endcomponent
