{{-- <div class="flex items-center gap-1">
    <flux:modal.trigger name="view-project-modal">
        <flux:button variant="ghost" size="sm" icon="eye"
            wire:click="$dispatch('view-project', { id: {{ $row->id }} })"
            class="text-red-400 hover:text-zinc-800 dark:text-zinc-500 dark:hover:text-zinc-200 transition-colors duration-200" />
    </flux:modal.trigger>

    <flux:modal.trigger name="edit-project-modal">
        <flux:button variant="ghost" size="sm" icon="pencil"
            wire:click="$dispatch('edit-project', { id: {{ $row->id }} })"
            class="text-zinc-400 hover:text-zinc-800 dark:text-zinc-500 dark:hover:text-zinc-200 transition-colors duration-200" />
    </flux:modal.trigger>
</div> --}}


<div class="flex items-center gap-1">
    <flux:modal.trigger name="view-project-modal">
        <flux:button variant="ghost" size="sm" icon="eye"
            wire:click="$dispatch('view-project', { id: {{ $row->id }} })"
            class="text-neutral-400 hover:text-neutral-800 dark:text-neutral-500 dark:hover:text-neutral-200 transition-colors duration-200" />
    </flux:modal.trigger>

    <flux:modal.trigger name="edit-project-modal">
        <flux:button variant="ghost" size="sm" icon="pencil"
            wire:click="$dispatch('edit-project', { id: {{ $row->id }} })"
            class="text-neutral-400 hover:text-neutral-800 dark:text-neutral-500 dark:hover:text-neutral-200 transition-colors duration-200" />
    </flux:modal.trigger>

    <flux:dropdown>
        <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" 
            class="text-neutral-400 hover:text-neutral-800 dark:text-neutral-500 dark:hover:text-neutral-200 transition-colors duration-200" />

        <flux:menu>
            <flux:menu.submenu heading="Client Portal">
                
                <flux:menu.item icon="arrow-top-right-on-square" 
                    href="{{ route('client.portal', ['uuid' => $row->uuid]) }}" target="_blank">
                    Preview as Client
                </flux:menu.item>
                
                <flux:menu.item icon="clipboard-document"
                    x-data
                    x-on:click="navigator.clipboard.writeText('{{ route('client.portal', ['uuid' => $row->uuid]) }}'); $dispatch('notify', { message: 'Portal link copied!' })">
                    Copy Portal Link
                </flux:menu.item>

            </flux:menu.submenu>

            <flux:menu.separator />

            <flux:menu.item icon="chat-bubble-left-ellipsis" 
                wire:click="$dispatch('resend-whatsapp', { id: {{ $row->id }} })">
                Send via WhatsApp
            </flux:menu.item>

            <flux:menu.separator />

            <flux:menu.item variant="danger" icon="trash" 
                wire:click="$dispatch('delete-project', { id: {{ $row->id }} })">
                Delete Project
            </flux:menu.item>
        </flux:menu>
    </flux:dropdown>
</div>