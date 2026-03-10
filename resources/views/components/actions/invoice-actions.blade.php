@props(['row'])

<div class="flex items-center gap-1">

    {{-- View Action --}}
    <flux:tooltip content="View invoice" position="top">
        <button wire:click="$dispatchTo('invoices.invoice-form-modal', 'view-invoice', { id: {{ $row->id }} })"
            class="flex items-center justify-center size-8 rounded-md text-zinc-500 hover:text-zinc-900 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:text-zinc-100 dark:hover:bg-zinc-800 transition-all duration-200 ease-out active:scale-95">
            <flux:icon.eye class="size-4" />
        </button>
    </flux:tooltip>


    {{-- Edit Action --}}
    <flux:tooltip content="Edit invoice" position="top">
        <button wire:click="$dispatchTo('invoices.invoice-form-modal', 'edit-invoice', { id: {{ $row->id }} })"
            class="flex items-center justify-center size-8 rounded-md text-zinc-500 hover:text-zinc-900 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:text-zinc-100 dark:hover:bg-zinc-800 transition-all duration-200 ease-out active:scale-95">
            <flux:icon.pencil class="size-4" />
        </button>
    </flux:tooltip>


    {{-- Download Action --}}
    <flux:tooltip content="Download PDF" position="top">
        <button wire:click="$dispatchTo('invoices.invoice-form-modal', 'download-invoice', { id: {{ $row->id }} })"
            wire:loading.attr="disabled"
            class="relative flex items-center justify-center size-8 rounded-md text-zinc-500 hover:text-zinc-900 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:text-zinc-100 dark:hover:bg-zinc-800 transition-all duration-200 ease-out active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">

            {{-- Loading Spinner --}}
            <svg wire:loading
                wire:target="$dispatchTo('invoices.invoice-form-modal', 'download-invoice', { id: {{ $row->id }} })"
                class="animate-spin size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>

            {{-- Download Icon --}}
            <flux:icon.arrow-down-tray wire:loading.remove
                wire:target="$dispatchTo('invoices.invoice-form-modal', 'download-invoice', { id: {{ $row->id }} })"
                class="size-4" />

        </button>
    </flux:tooltip>

</div>
