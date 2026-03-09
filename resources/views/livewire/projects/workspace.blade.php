<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 space-y-6">
    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif

    @if (session('warning'))
        <x-notification type="warning">{{ session('warning') }}</x-notification>
    @endif

    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif


    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('projects') }}" wire:navigate
                class="inline-flex items-center text-sm font-medium text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200 transition-colors mb-2">
                <flux:icon.chevron-left class="size-4 mr-1" />
                Back to Projects
            </a>

            <div class="flex items-center gap-3">
                <flux:heading size="xl" class="font-bold">{{ $project->name }}</flux:heading>
                <flux:badge color="blue" size="sm" class="uppercase">{{ $project->status ?? 'Active' }}
                </flux:badge>
            </div>
            <flux:subheading class="mt-1">
                Client: <span
                    class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $project->client->client_name }}</span>
            </flux:subheading>
        </div>

        <div class="flex items-center gap-3">
            <flux:button variant="ghost" icon="pencil"
                wire:click="$dispatchTo('projects.project-form-modal', 'open-project-modal', { id: {{ $project->id }} })">
                Edit Details
            </flux:button>
            <x-primary-button wire:click="$dispatchTo('projects.project-form-modal', 'send-whatsapp-to-client', { id: {{ $project->id }} })">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
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
                class="p-4 flex flex-wrap gap-6 sm:gap-12 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700/50 shadow-sm">
                <div>
                    <p class="text-xs text-zinc-500 uppercase tracking-wide font-medium">Deadline</p>
                    <p class="mt-1 font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-zinc-500 uppercase tracking-wide font-medium">Project Value</p>
                    <p class="mt-1 font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ $project->currency->symbol ?? '$' }} {{ number_format($project->value, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-zinc-500 uppercase tracking-wide font-medium">Hourly Rate</p>
                    <p class="mt-1 font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ $project->currency->symbol ?? '$' }}{{ number_format($project->hourly_rate, 2) }}</p>
                </div>
            </div>

            {{-- this handles the tasks creation, deletion etc. --}}
            <livewire:projects.task-manager :project="$project" />

        </div>

        <div class="space-y-6">

            <div class="p-5 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <flux:heading size="md">Invoices</flux:heading>
                    <flux:button size="sm" variant="ghost" icon="plus">Create</flux:button>
                </div>

                <div
                    class="border-2 border-dashed border-zinc-200 dark:border-zinc-700 rounded-lg p-6 text-center text-zinc-500 text-sm">
                    No invoices generated yet.
                </div>
            </div>

            <div class="p-5 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <flux:heading size="md" class="mb-3">Project Scope</flux:heading>
                <div
                    class="text-sm text-zinc-600 dark:text-zinc-400 whitespace-pre-line bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700/50">
                    {{ $project->description ?: 'No specific description provided.' }}
                </div>
            </div>

        </div>
    </div>

    <livewire:projects.project-form-modal />
</div>
