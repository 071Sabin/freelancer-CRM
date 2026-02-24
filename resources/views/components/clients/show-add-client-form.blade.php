@props(['currencies'])

<flux:modal name="add-client" class="max-w-2xl">
    <flux:heading size="lg">Add New Client</flux:heading>

    <x-hr-divider />

    <div class="lg:grid grid-cols-2 gap-3 my-6">
        <x-input-field model="clientname" type="text" placeholder="Enter client name" label="Client Name" required />

        <x-input-field model="clientemail" type="email" placeholder="Enter client email" label="Client Email"
            required />

        <x-input-field model="companyname" type="text" placeholder="Enter company name" label="Company Name"
            required />

        <x-input-field model="companyemail" type="email" placeholder="Company email" label="Company Email" />

        <x-input-field model="website" type="text" placeholder="Company website" label="Company Website" />

        <x-input-field model="companyphone" type="text" placeholder="Company phone" label="Company Phone" required />

        <x-input-field model="billing_address" type="text" placeholder="Billing Address...." label="Billing Address"
            required />


        <div class="flex flex-col lg:flex-row gap-2">
            <x-input-field model="hrate" type="number" placeholder="Hourly rate" label="Hourly Rate" required
                class="" />

            <flux:select wire:model="currency_id" label="Currency" placeholder="-- Select Currency --" required>

                @foreach ($currencies as $currency)
                    <flux:select.option value="{{ $currency->id }}">
                        {{ $currency->code }} — {{ $currency->symbol }}
                    </flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <flux:select wire:model="status" label="System Status" placeholder="-- Select Status --" required>
            <flux:select.option value="active">Active</flux:select.option>
            <flux:select.option value="inactive">Inactive</flux:select.option>
            <flux:select.option value="lead">Lead</flux:select.option>
        </flux:select>
    </div>
    <flux:textarea label="Private Notes" placeholder="Private notes for yourself" wire:model="privatenote" />

    <div class="flex justify-start gap-2 mt-3">
        <x-primary-button wire:click="addClient">add client</x-primary-button>
    </div>

</flux:modal>
