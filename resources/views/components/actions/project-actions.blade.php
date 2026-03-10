<div class="flex items-center gap-0.5 sm:gap-1">
    <div class="flex items-center gap-1">

        {{-- View Action --}}
        <flux:tooltip content="View project" position="top">

            <a href="{{ route('projects.workspace', ['uuid' => $row->uuid]) }}" wire:navigate
                class="flex items-center justify-center size-8 rounded-md text-neutral-500 hover:text-neutral-900 hover:bg-neutral-100 dark:text-neutral-400 dark:hover:text-neutral-100 dark:hover:bg-neutral-800
                   transition-all duration-200 ease-out active:scale-95">

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    <path fill-rule="evenodd"
                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                        clip-rule="evenodd" />
                </svg>
            </a>

        </flux:tooltip>


        {{-- Edit Action --}}
        <flux:tooltip content="Edit project" position="top">

            <button
                wire:click="$dispatchTo('projects.project-form-modal','open-project-modal',{ id: {{ $row->id }} })"
                class="flex items-center justify-center size-8 rounded-md text-neutral-500 hover:text-neutral-900 hover:bg-neutral-100 dark:text-neutral-400 dark:hover:text-neutral-100 dark:hover:bg-neutral-800
                   transition-all duration-200 ease-out active:scale-95">

                <flux:icon.pencil class="size-4" />

            </button>

        </flux:tooltip>

    </div>

    {{-- More Actions Dropdown --}}
    <flux:dropdown>
        <flux:tooltip content="More options" position="top">
            <flux:button variant="ghost" size="sm" icon="ellipsis-vertical"
                class="text-neutral-400 hover:text-neutral-800 hover:bg-neutral-100/80 dark:text-neutral-500 dark:hover:text-neutral-200 dark:hover:bg-neutral-800/60 transition-all duration-200 ease-out active:scale-[0.97]" />
        </flux:tooltip>

        <flux:menu>
            <flux:menu.submenu heading="Client Portal" icon="user">

                <flux:menu.item icon="arrow-top-right-on-square"
                    href="{{ route('client.portal', ['uuid' => $row->uuid]) }}" target="_blank">
                    Preview as Client
                </flux:menu.item>

                <div x-data="{ copied: false }" class="contents">
                    <flux:menu.item x-show="!copied" icon="clipboard-document"
                        x-on:click.prevent.stop="navigator.clipboard.writeText('{{ route('client.portal', ['uuid' => $row->uuid]) }}'); copied = true; setTimeout(() => copied = false, 2500); $dispatch('notify', { message: 'Portal link copied!' });">
                        Copy Portal Link
                    </flux:menu.item>

                    <flux:menu.item x-cloak x-show="copied" icon="check-circle"
                        class="!text-emerald-600 dark:!text-emerald-400 font-medium">
                        Copied Successfully!
                    </flux:menu.item>
                </div>
            </flux:menu.submenu>

            <flux:menu.separator />

            <flux:menu.item icon="chat-bubble-left-ellipsis"
                wire:click.stop="$dispatchTo('projects.project-form-modal', 'send-whatsapp-to-client', { id: {{ $row->id }} })">
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
