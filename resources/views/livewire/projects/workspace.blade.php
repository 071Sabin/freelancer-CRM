<div class="">
    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif

    @if (session('warning'))
        <x-notification type="warning">{{ session('warning') }}</x-notification>
    @endif

    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif


    <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-4">
        <div class="space-y-2">

            {{-- Back link --}}
            <a href="{{ route('projects') }}" wire:navigate
                class="inline-flex items-center gap-1 py-1 text-sm font-medium text-neutral-500 hover:text-neutral-800 dark:hover:text-neutral-200 transition-colors">
                <flux:icon.chevron-left class="size-4" />
                <span class="hidden sm:inline">Back to Projects</span>
                <span class="sm:hidden text-xs">Back</span>
            </a>

            {{-- Project Title + Status --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 min-w-0">
                <div class="flex flex-col">
                    <h1
                        class="font-semibold text-neutral-900 dark:text-neutral-100 text-lg sm:text-xl lg:text-2xl leading-tight tracking-tight truncate">
                        {{ $project->name }}
                    </h1>
                    {{-- Client --}}
                    <flux:subheading class="flex items-center gap-2 text-sm text-neutral-500">
                        <flux:icon.user class="size-4 text-neutral-400 shrink-0" />

                        <span class="text-xs md:text-sm text-neutral-800 dark:text-neutral-400 truncate">
                            {{ $project->client->client_name }}
                        </span>
                    </flux:subheading>
                </div>
                @php
                    $status = strtolower($project->status ?? '');

                    $statusHtml = match ($status) {
                        'active'
                            => '<span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-500/10 dark:text-blue-400 dark:ring-blue-500/20">Active</span>',

                        'in_progress'
                            => '<span class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-800 ring-1 ring-inset ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-500 dark:ring-amber-400/20">In Progress</span>',

                        'on_hold'
                            => '<span class="inline-flex items-center rounded-md bg-yellow-50 px-2.5 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20 dark:bg-yellow-400/10 dark:text-yellow-400 dark:ring-yellow-400/20">On Hold</span>',

                        'completed'
                            => '<span class="inline-flex items-center rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20 dark:bg-emerald-400/10 dark:text-emerald-400 dark:ring-emerald-400/20">Completed</span>',

                        'cancelled'
                            => '<span class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/20">Cancelled</span>',

                        default
                            => '<span class="inline-flex items-center rounded-md bg-neutral-50 px-2.5 py-1 text-xs font-medium text-neutral-600 ring-1 ring-inset ring-neutral-500/10 dark:bg-neutral-400/10 dark:text-neutral-400 dark:ring-neutral-400/20">' .
                            ucfirst(str_replace('_', ' ', $status ?: 'unknown')) .
                            '</span>',
                    };
                @endphp

                <div class="flex gap-3">
                    <div>{!! $statusHtml !!}</div>
                    <div class="flex items-center gap-2">
                        <flux:tooltip content="View as Client">
                            {{-- Open Client Portal --}}
                            <a href="{{ route('client.portal', ['uuid' => $project->uuid]) }}" target="_blank"
                                class="text-gray-500 hover:text-blue-600" x-data x-tooltip="'Open in New Tab'">
                                <flux:icon.arrow-top-right-on-square class="w-5 h-5" />
                            </a>
                        </flux:tooltip>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex items-center gap-3 my-2 justify-center">
            <flux:button variant="ghost" icon="pencil" class="text-xs md:text-sm"
                wire:click="$dispatchTo('projects.project-form-modal', 'open-project-modal', { id: {{ $project->id }} })">
                Edit
            </flux:button>


            <flux:separator vertical />

            <x-primary-button class="gap-2"
                wire:click="$dispatchTo('projects.project-form-modal','send-whatsapp-to-client',{ id: {{ $project->id }} })"
                wire:loading.attr="disabled">

                <svg wire:loading.remove wire:target="sendWhatsappMessage" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path
                        d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                </svg>

                <span wire:loading.remove wire:target="sendWhatsappMessage">
                    Send Update
                </span>

                <span wire:loading wire:target="sendWhatsappMessage">
                    Sending...
                </span>

            </x-primary-button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        <div class="lg:col-span-2 space-y-6">

            <div
                class="p-4 flex flex-wrap gap-6 sm:gap-12 bg-neutral-50/70 dark:bg-neutral-800/50 rounded-lg border border-neutral-300 dark:border-neutral-700/50">
                <div>
                    <p class="text-xs text-neutral-500 uppercase tracking-wide font-medium">Deadline</p>
                    <p class="mt-1 font-semibold text-neutral-900 dark:text-neutral-100 text-xs md:text-base">
                        {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-neutral-500 uppercase tracking-wide font-medium">Project Value</p>
                    <p class="mt-1 font-semibold text-neutral-900 dark:text-neutral-100 text-xs md:text-base">
                        {{ $project->currency->symbol ?? '$' }} {{ number_format($project->value, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-neutral-500 uppercase tracking-wide font-medium">Hourly Rate</p>
                    <p class="mt-1 font-semibold text-neutral-900 dark:text-neutral-100 text-xs md:text-base">
                        {{ $project->currency->symbol ?? '$' }}{{ number_format($project->hourly_rate, 2) }}</p>
                </div>
            </div>

            {{-- this handles the tasks creation, deletion etc. --}}
            <livewire:projects.task-manager />

        </div>

        <div class="space-y-6">
            <livewire:projects.workspace-invoices :project="$project" />

            <div class="p-5 bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 ">
                <flux:heading size="md" class="mb-3">Project Description</flux:heading>
                <div
                    class="text-sm text-neutral-600 dark:text-neutral-400 bg-neutral-50 dark:bg-neutral-900/50 p-3 rounded-lg border border-neutral-200 dark:border-neutral-700/50">
                    {{ $project->description ?: 'No specific description provided.' }}
                </div>
            </div>
        </div>
    </div>

    <livewire:invoices.invoice-form-modal />

    <livewire:projects.project-form-modal />
</div>
