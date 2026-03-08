<div class="flex items-center gap-0.5 sm:gap-1">
    {{-- View Action --}}
    <flux:tooltip content="View project" position="top">
        <flux:button variant="ghost" size="sm" icon="eye"
            wire:click="$dispatch('view-project', { id: {{ $row->id }} })"
            class="text-zinc-400 hover:text-zinc-800 hover:bg-zinc-100/80 dark:text-zinc-500 dark:hover:text-zinc-200 dark:hover:bg-zinc-800/60 transition-all duration-200 ease-out active:scale-[0.97]" />
    </flux:tooltip>

    {{-- Edit Action --}}
    <flux:tooltip content="Edit project" position="top">
        <flux:button variant="ghost" size="sm" icon="pencil"
            wire:click="$dispatch('edit-project', { id: {{ $row->id }} })"
            class="text-zinc-400 hover:text-zinc-800 hover:bg-zinc-100/80 dark:text-zinc-500 dark:hover:text-zinc-200 dark:hover:bg-zinc-800/60 transition-all duration-200 ease-out active:scale-[0.97]" />
    </flux:tooltip>

    {{-- More Actions Dropdown --}}
    <flux:dropdown>
        <flux:tooltip content="More options" position="top">
            <flux:button variant="ghost" size="sm" icon="ellipsis-vertical"
                class="text-zinc-400 hover:text-zinc-800 hover:bg-zinc-100/80 dark:text-zinc-500 dark:hover:text-zinc-200 dark:hover:bg-zinc-800/60 transition-all duration-200 ease-out active:scale-[0.97]" />
        </flux:tooltip>

        <flux:menu>
            <flux:menu.submenu heading="Client Portal">
                
                <flux:menu.item icon="arrow-top-right-on-square"
                    href="{{ route('client.portal', ['uuid' => $row->uuid]) }}" target="_blank">
                    Preview as Client
                </flux:menu.item>

                <div x-data="{ copied: false }" class="contents">
                    <flux:menu.item 
                        x-show="!copied" 
                        icon="clipboard-document"
                        x-on:click.prevent.stop="navigator.clipboard.writeText('{{ route('client.portal', ['uuid' => $row->uuid]) }}'); copied = true; setTimeout(() => copied = false, 2500); $dispatch('notify', { message: 'Portal link copied!' });"
                    >
                        Copy Portal Link
                    </flux:menu.item>

                    <flux:menu.item 
                        x-cloak
                        x-show="copied" 
                        icon="check-circle"
                        class="!text-emerald-600 dark:!text-emerald-400 font-medium"
                    >
                        Copied Successfully!
                    </flux:menu.item>
                </div>
            </flux:menu.submenu>

            <flux:menu.separator />

            <flux:menu.item icon="chat-bubble-left-ellipsis"
                wire:click.stop="$dispatch('resend-whatsapp', { id: {{ $row->id }} })">
                Send via WhatsApp
            </flux:menu.item>

            <flux:menu.separator />

            <flux:menu.item variant="danger" icon="trash"
                wire:click="$dispatch('confirm-delete', { id: {{ $row->id }} })">
                Delete Project
            </flux:menu.item>
        </flux:menu>
    </flux:dropdown>
</div>
