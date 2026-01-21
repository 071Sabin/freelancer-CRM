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

        <x-input-field model="billing_address" type="textarea" placeholder="Billing Address...." label="Billing Address"
            required />


        <div class="flex flex-col lg:flex-row gap-2">
            <x-input-field model="hrate" type="number" placeholder="Hourly rate" label="Hourly Rate" required />
            <div>
                <label for="" class="text-gray-800 dark:text-neutral-400 text-sm">Currency
                    <span class="text-red-500">*</span></label>
                <select wire:model="currency" id=""
                    class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400 dark:placeholder:text-neutral-500 transition-all duration-150">
                    <option value="" selected>-- Select --</option>
                    <option value="usd">USD — $</option>
                    <option value="eur">EUR — €</option>
                    <option value="gbp">GBP — £</option>
                    <option value="inr">INR — ₹</option>
                </select>
            </div>
        </div>

        <div>
            <label for="" class="text-gray-800 dark:text-neutral-400 text-sm">System
                Status <span class="text-red-500">*</span></label>
            <select wire:model="status" id="" required
                class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400 dark:placeholder:text-neutral-500 transition-all duration-150">
                <option value="" selected>-- Select Status --</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="lead">Lead</option>
            </select>
        </div>
        <div class=" col-span-2">
            <label for="" class="text-gray-800 dark:text-neutral-400 text-sm">Private
                Notes</label>
            <textarea placeholder="Private notes for yourself" wire:model="privatenote"
                class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400 dark:placeholder:text-neutral-500 transition-all duration-150"></textarea>
        </div>

    </div>
    <div class="flex justify-start gap-2">
        <x-primary-button wire:click="addClient">add client</x-primary-button>
    </div>

</flux:modal>
