<div class="flex items-center gap-1">
    {{-- View Action --}}
    <flux:tooltip content="View details" position="left">
        <flux:modal.trigger name="view-client-modal">
            <flux:button variant="ghost" size="sm" icon="eye"
                wire:click="$dispatch('view-client',{ id: {{ $row->id }} })"
                class="!h-8 !w-8 !rounded-lg 
                       text-zinc-400 hover:text-zinc-900 hover:bg-zinc-100 
                       dark:text-zinc-500 dark:hover:text-zinc-100 dark:hover:bg-white/10 
                       transition-all duration-200 active:scale-90" />
        </flux:modal.trigger>
    </flux:tooltip>

    {{-- Edit Action --}}
    <flux:tooltip content="Edit client" position="left">
        <flux:modal.trigger name="edit-client-modal">
            <flux:button variant="ghost" size="sm" icon="pencil"
                wire:click="$dispatch('edit-client',{ id: {{ $row->id }} })"
                class="!h-8 !w-8 !rounded-lg 
                       text-zinc-400 hover:text-zinc-900 hover:bg-zinc-100 
                       dark:text-zinc-500 dark:hover:text-zinc-100 dark:hover:bg-white/10 
                       transition-all duration-200 active:scale-90" />
        </flux:modal.trigger>
    </flux:tooltip>
</div>