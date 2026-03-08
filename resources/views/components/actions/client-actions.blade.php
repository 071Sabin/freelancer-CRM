<div class="flex items-center gap-0.5 sm:gap-1">
    {{-- View Action --}}
    <flux:tooltip content="View details" position="top">
        <flux:button variant="ghost" size="sm" icon="eye"
            wire:click="$dispatch('view-client',{ id: {{ $row->id }} })"
            class="text-zinc-400 hover:text-zinc-800 hover:bg-zinc-100/80 dark:text-zinc-500 dark:hover:text-zinc-200 dark:hover:bg-zinc-800/60 transition-all duration-200 ease-out active:scale-[0.97]" />
    </flux:tooltip>

    {{-- Edit Action --}}
    <flux:tooltip content="Edit client" position="top">
        <flux:button variant="ghost" size="sm" icon="pencil"
            wire:click="$dispatch('edit-client',{ id: {{ $row->id }} })"
            class="text-zinc-400 hover:text-zinc-800 hover:bg-zinc-100/80 dark:text-zinc-500 dark:hover:text-zinc-200 dark:hover:bg-zinc-800/60 transition-all duration-200 ease-out active:scale-[0.97]" />
    </flux:tooltip>
</div>