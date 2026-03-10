<div class="flex items-center gap-1">

    {{-- View Action --}}
    <flux:tooltip content="View details" position="top">
        <button
            wire:click="$dispatch('view-client',{ id: {{ $row->id }} })"
            class="flex items-center justify-center size-8 rounded-md
                   text-zinc-500 hover:text-zinc-900
                   hover:bg-zinc-100
                   dark:text-zinc-400 dark:hover:text-zinc-100
                   dark:hover:bg-zinc-800
                   transition-all duration-200 ease-out
                   active:scale-95">

            <flux:icon.eye class="size-4" />

        </button>
    </flux:tooltip>


    {{-- Edit Action --}}
    <flux:tooltip content="Edit client" position="top">
        <button
            wire:click="$dispatch('edit-client',{ id: {{ $row->id }} })"
            class="flex items-center justify-center size-8 rounded-md
                   text-zinc-500 hover:text-zinc-900
                   hover:bg-zinc-100
                   dark:text-zinc-400 dark:hover:text-zinc-100
                   dark:hover:bg-zinc-800
                   transition-all duration-200 ease-out
                   active:scale-95">

            <flux:icon.pencil class="size-4" />

        </button>
    </flux:tooltip>

</div>