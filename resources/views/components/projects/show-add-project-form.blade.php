@props(['clients', 'currencies'])

<flux:modal name="add-project">
    <form wire:submit.prevent="createProject" class="flex flex-col w-full max-w-3xl rounded-xl">

        <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800">
            <div>
                <h2 class="text-lg font-semibold tracking-tight sm:text-xl text-neutral-900 dark:text-neutral-100">Add
                    Project</h2>
                <p class="mt-0.5 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">Enter the project details and
                    billing information.</p>
            </div>
        </div>

        <div class="flex flex-col gap-y-5 pt-5 sm:gap-y-6">

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="space-y-1">
                    <x-input-field model="name" type="text" placeholder="e.g. Acme Redesign" label="Project Name"
                        required />
                </div>

                <flux:select wire:model.live="client_id" label="Client" required placeholder="-- select client --">
                    @foreach ($clients as $client)
                        <flux:select.option value="{{ $client->id }}">
                            {{ $client->client_name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <flux:select wire:model="status" label="Status" placeholder="Select status" required>
                    <flux:select.option value="active">Active</flux:select.option>
                    <flux:select.option value="in_progress">In Progress</flux:select.option>
                    <flux:select.option value="on_hold">On Hold</flux:select.option>
                    <flux:select.option value="completed">Completed</flux:select.option>
                    <flux:select.option value="cancelled">Cancelled</flux:select.option>
                </flux:select>

                <div class="space-y-1">
                    <x-input-field type="date" model="deadline" label="Deadline" required />
                </div>
            </div>

            <div
                class="p-4 border rounded-lg border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-800/20">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="space-y-1">
                        <x-input-field model="value" type="number" step="0.01" placeholder="1500.00"
                            label="Project Value" required />
                    </div>

                    <flux:select wire:model="currency_id" label="Currency">
                        @foreach ($currencies as $c)
                            <flux:select.option value="{{ $c->id }}">
                                {{ $c->code }} - {{ $c->symbol }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <div class="space-y-1">
                        <x-input-field type="text" model="hourly_rate" placeholder="150.00" label="Rate/Hr."
                            required />
                    </div>
                </div>
            </div>
            
            <flux:textarea label="Description" wire:model.defer="description" placeholder="Brief project details..." />

        </div>

        <div class="flex items-center justify-end py-4 rounded-b-xl">
            <x-primary-button type="submit" class="w-fit">Create Project</x-primary-button>
        </div>

    </form>
</flux:modal>
