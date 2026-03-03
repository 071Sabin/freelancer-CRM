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


                <div x-data="{ copied: false }" class="contents">
                    <flux:menu.item x-show="!copied" icon="clipboard-document"
                        x-on:click.prevent.stop="navigator.clipboard.writeText('{{ route('client.portal', ['uuid' => $row->uuid]) }}'); copied = true; setTimeout(() => copied = false, 4000); $dispatch('notify', { message: 'Portal link copied!' });">
                        Copy Portal Link
                    </flux:menu.item>

                    <flux:menu.item x-show="copied" style="display: none;" icon="check-circle"
                        class="text-green-600 dark:text-green-400 font-medium">
                        Copied Successfully!
                    </flux:menu.item>
                </div>

            </flux:menu.submenu>

            <flux:menu.separator />

            <flux:menu.item icon="chat-bubble-left-ellipsis"
                wire:click="$dispatch('resend-whatsapp', { id: {{ $row->id }} })">
                Send via WhatsApp
            </flux:menu.item>

            <flux:menu.separator />

            <flux:modal.trigger name="delete-project-modal">
                <flux:menu.item variant="danger" icon="trash">
                    Delete Project
                </flux:menu.item>
            </flux:modal.trigger>
            {{-- <flux:menu.item variant="danger" icon="trash"
                wire:click="$dispatch('delete-project', { id: {{ $row->id }} })">
                Delete Project
            </flux:menu.item> --}}
        </flux:menu>
    </flux:dropdown>


    <flux:modal name="delete-project-modal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete project?</flux:heading>

                <flux:text class="mt-2">
                    You're about to delete this project.<br>
                    This action cannot be reversed.
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <x-secondary-button>cancel</x-secondary-button>
                </flux:modal.close>

                <x-danger-button type='submit'
                    wire:click="$dispatch('delete-project', { id: {{ $row->id }} })">delete project</x-danger-button>
            </div>
        </div>
    </flux:modal>
</div>
