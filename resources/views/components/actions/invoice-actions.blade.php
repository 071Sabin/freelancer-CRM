{{-- <div class="flex items-center gap-1">
    <flux:button variant="ghost" size="sm" wire:click="downloadPdf({{ $row->id }})" wire:loading.attr="disabled"
        wire:loading.class="opacity-50 cursor-not-allowed"
        class="text-neutral-400 hover:text-neutral-800 dark:text-neutral-500 dark:hover:text-neutral-200 transition-colors duration-200">

        <div wire:loading wire:target="downloadPdf({{ $row->id }})">
            <svg class="animate-spin h-4 w-4 text-neutral-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>

        <div wire:loading.remove wire:target="downloadPdf({{ $row->id }})">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
        </div>
    </flux:button>

    <flux:button variant="ghost" size="sm" icon="eye"
        wire:click="$dispatch('view-invoice', { id: {{ $row->id }} })"
        class="text-neutral-400 hover:text-neutral-800 dark:text-neutral-500 dark:hover:text-neutral-200 transition-colors duration-200" />

    <flux:button variant="ghost" size="sm" icon="pencil"
        wire:click="$dispatch('edit-invoice', { id: {{ $row->id }} })"
        class="text-neutral-400 hover:text-neutral-800 dark:text-neutral-500 dark:hover:text-neutral-200 transition-colors duration-200" />

</div> --}}




<div class="flex items-center gap-0.5 sm:gap-1">
    {{-- Download Action --}}
    <flux:tooltip content="Download PDF" position="top">
        <flux:button variant="ghost" size="sm" 
            wire:click="downloadPdf({{ $row->id }})" 
            wire:loading.attr="disabled"
            class="relative flex items-center justify-center !px-2.5 text-zinc-400 hover:text-zinc-800 hover:bg-zinc-100/80 dark:text-zinc-500 dark:hover:text-zinc-200 dark:hover:bg-zinc-800/60 transition-all duration-200 ease-out active:scale-[0.97] disabled:opacity-50 disabled:cursor-not-allowed">
            
            <div wire:loading wire:target="downloadPdf({{ $row->id }})" class="absolute inset-0 flex items-center justify-center">
                <svg class="animate-spin w-4 h-4 text-zinc-500 dark:text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <div wire:loading.remove wire:target="downloadPdf({{ $row->id }})" class="flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            </div>
        </flux:button>
    </flux:tooltip>

    {{-- View Action --}}
    <flux:tooltip content="View invoice" position="top">
        <flux:button variant="ghost" size="sm" icon="eye"
            wire:click="$dispatch('view-invoice', { id: {{ $row->id }} })"
            class="text-zinc-400 hover:text-zinc-800 hover:bg-zinc-100/80 dark:text-zinc-500 dark:hover:text-zinc-200 dark:hover:bg-zinc-800/60 transition-all duration-200 ease-out active:scale-[0.97]" />
    </flux:tooltip>

    {{-- Edit Action --}}
    <flux:tooltip content="Edit invoice" position="top">
        <flux:button variant="ghost" size="sm" icon="pencil"
            wire:click="$dispatch('edit-invoice', { id: {{ $row->id }} })"
            class="text-zinc-400 hover:text-zinc-800 hover:bg-zinc-100/80 dark:text-zinc-500 dark:hover:text-zinc-200 dark:hover:bg-zinc-800/60 transition-all duration-200 ease-out active:scale-[0.97]" />
    </flux:tooltip>
</div>