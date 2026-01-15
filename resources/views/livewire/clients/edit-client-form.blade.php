<div class="bg-none">
    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif
    @if ($open)
        <div
            class="modal border border-white fixed z-99 top-0 left-0 bg-black/50 backdrop-blur-md w-full h-full flex flex-wrap items-center justify-center">
            <form wire:submit="saveClientEdit" class="bg-white dark:bg-neutral-800 rounded-lg w-1/2 p-5">
                <h1 class="text-xl font-bold flex justify-between">Edit Client Details
                    <button wire:click="closeEdit" type="button">
                        <i class="bi bi-x-lg text-red-500 cursor-pointer"></i>
                    </button>
                </h1>
                <hr class="text-neutral-300 dark:bg-neutral-700 my-5">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                    <!-- Row 1 -->
                    <x-input-field type="text" model="editClient.client_name" label="Client Name"
                        placeholder="Enter client name" required />

                    <x-input-field type="text" model="editClient.company_name" label="Company Name"
                        placeholder="Enter company name" required />

                    <!-- Row 2 -->
                    <x-input-field type="email" model="editClient.company_email" label="Company Email"
                        placeholder="company@example.com" />

                    <x-input-field type="text" model="editClient.company_website" label="Company Website"
                        placeholder="https://example.com" />

                    <!-- Row 3 -->
                    <x-input-field type="text" model="editClient.company_phone" label="Company Phone"
                        placeholder="+1 555 555 5555" required />

                    <!-- Billing address (full width) -->
                    <x-input-field type="textarea" model="editClient.billing_address" label="Billing Address"
                        placeholder="Billing address..." class="col-span-2" required />

                    <!-- Hourly rate + Currency grouped -->
                    <div class="flex flex-col lg:flex-row gap-2">
                        <x-input-field type="number" model="editClient.hourly_rate" label="Hourly Rate"
                            placeholder="Hourly rate" required />

                        <div class="w-full">
                            <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Currency
                                <span class="text-red-500">*</span></label>
                            <select wire:model="editClient.currency"
                                class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150"
                                required>
                                <option value="" selected>-- Select --</option>
                                <option value="usd">USD — $</option>
                                <option value="eur">EUR — €</option>
                                <option value="gbp">GBP — £</option>
                                <option value="inr">INR — ₹</option>
                            </select>
                            @error('editClient.currency')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- System Status -->
                    <div>
                        <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">System Status
                            <span class="text-red-500">*</span></label>
                        <select wire:model="editClient.status"
                            class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150"
                            required>
                            <option value="" selected>-- Select Status --</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="lead">Lead</option>
                        </select>
                        @error('editClient.status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Private notes (full width) -->
                    <div class="col-span-2">
                        <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Private
                            Notes</label>
                        <textarea wire:model="editClient.private_notes" placeholder="Private notes for yourself"
                            class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150"></textarea>
                        @error('editClient.private_notes')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit"
                    class="bg-blue-500 px-3 py-2 text-white rounded hover:bg-blue-600 cursor-pointer mt-5">Save</button>
            </form>
        </div>
    @endif
</div>
