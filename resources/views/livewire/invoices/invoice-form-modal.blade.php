<div>
    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif

    @if (session('warning'))
        <x-notification type="warning">{{ session('warning') }}</x-notification>
    @endif

    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif

    <flux:modal name="create-invoice-modal" class="max-w-lg">
        <form wire:submit.prevent="create" class="space-y-6">
            <div>
                <flux:heading size="lg">Create New Invoice</flux:heading>
                <flux:text class="text-neutral-500">
                    Start by selecting a client. You can add items in the next step.
                </flux:text>
                @if ($due_date_note)
                    <p class="mt-2 text-xs text-yellow-500 dark:text-yellow-400">
                        {{ $due_date_note }}
                    </p>
                @endif
            </div>


            {{-- search/select dropdown for projects and clients --}}
            <div x-data="{ open: false }" class="relative mb-4" @click.outside="open = false">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Client</label>

                <button @click="open = !open" type="button"
                    class="w-full flex justify-between items-center bg-white dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-lg px-3 py-2 text-sm text-neutral-900 dark:text-neutral-100 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-shadow">
                    <span class="truncate">
                        @php
                            // Find the selected client name to display when the dropdown is closed
                            $selectedClient = $this->searchedClients->firstWhere('id', $client_id);
                        @endphp
                        {{ $selectedClient ? ucwords($selectedClient->client_name) : 'Select client...' }}
                    </span>
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open" x-transition.opacity.duration.200ms
                    class="absolute z-50 mt-1 w-full bg-white dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-lg overflow-hidden flex flex-col"
                    style="display: none;">
                    <div
                        class="flex items-center px-3 border-b border-neutral-200 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-700/50">
                        <svg class="w-4 h-4 text-neutral-400 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" wire:model.live.debounce.300ms="clientSearch"
                            class="w-full bg-transparent border-none focus:ring-0 text-sm py-2.5 px-2 text-neutral-900 dark:text-neutral-100 placeholder-neutral-500 dark:placeholder-neutral-400 outline-none"
                            placeholder="Search..." @keydown.escape.window="open = false">
                    </div>

                    <ul class="max-h-60 overflow-y-auto py-1">
                        @forelse ($this->searchedClients as $client)
                            <li wire:click="$set('client_id', {{ $client->id }}); open = false;"
                                class="px-3 py-2 text-sm cursor-pointer transition-colors duration-150 text-neutral-700 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-700 flex justify-between items-center">
                                <span>{{ ucwords($client->client_name) }}</span>
                                @if ($client_id == $client->id)
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </li>
                        @empty
                            <li class="px-3 py-3 text-sm text-neutral-500 dark:text-neutral-400 text-center">
                                No clients found.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>


            <div x-data="{ open: false }" class="relative mb-4" @click.outside="open = false">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Project</label>

                <button @click="open = !open" type="button"
                    class="w-full flex justify-between items-center bg-white dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-lg px-3 py-2 text-sm text-neutral-900 dark:text-neutral-100 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-shadow">
                    <span class="truncate">
                        @php
                            $selectedProject = $this->searchedProjects->firstWhere('id', $project_id);
                        @endphp
                        {{ $selectedProject ? $selectedProject->name : 'Select project...' }}
                    </span>
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition.opacity.duration.200ms
                    class="absolute z-50 mt-1 w-full bg-white dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-lg overflow-hidden flex flex-col"
                    style="display: none;">
                    <div
                        class="flex items-center px-3 border-b border-neutral-200 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-700/50">
                        <svg class="w-4 h-4 text-neutral-400 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" wire:model.live.debounce.300ms="projectSearch"
                            class="w-full bg-transparent border-none focus:ring-0 text-sm py-2.5 px-2 text-neutral-900 dark:text-neutral-100 placeholder-neutral-500 dark:placeholder-neutral-400 outline-none"
                            placeholder="Search..." @keydown.escape.window="open = false">
                    </div>

                    <ul class="max-h-60 overflow-y-auto py-1">
                        @forelse ($this->searchedProjects as $project)
                            <li wire:click="$set('project_id', {{ $project->id }}); open = false;"
                                class="px-3 py-2 text-sm cursor-pointer transition-colors duration-150 text-neutral-700 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-700 flex justify-between items-center">
                                <span>{{ $project->name }}</span>
                                @if ($project_id == $project->id)
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </li>
                        @empty
                            <li class="px-3 py-3 text-sm text-neutral-500 dark:text-neutral-400 text-center">
                                No projects found.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div>
                <p class="text-xs md:text-sm text-neutral-400">Project Currency: {{ $currency }}</p>
            </div>

            {{-- issue date and due date --}}
            <div class="grid grid-cols-2 gap-4">
                <flux:input type="date" label="Issue Date" wire:model.live="issue_date" />
                <div>
                    <flux:input type="date" label="Due Date" wire:model.defer="due_date" />
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <x-primary-button type="submit">
                    Create & Add Items
                </x-primary-button>
            </div>
        </form>
    </flux:modal>



    {{-- View Invoice Modal --}}
    <flux:modal name="view-invoice-modal" class="min-h-[600px] w-full md:min-w-[900px] dark:!bg-neutral-800 p-8">
        <div class="flex flex-col h-full">
            <div wire:loading wire:target="view">
                <div class="flex justify-center p-8">
                    <flux:icon.loading />
                </div>
            </div>

            <div wire:loading.remove wire:target="view" class="flex-1">
                @if ($viewingInvoice)
                    {{-- Print Preview Container --}}
                    <div
                        class="bg-white text-neutral-900 w-full max-w-4xl mx-auto shadow-xl rounded-sm print:shadow-none overflow-hidden flex flex-col min-h-[800px]">

                        {{-- Header --}}
                        <div
                            class="bg-neutral-50 px-10 py-8 border-b border-neutral-200 flex justify-between items-start">
                            <div class="w-1/2">
                                @if ($settings && $settings->logo_path)
                                    @php
                                        $logoUrl = null;
                                        if (file_exists(public_path('uploads/' . $settings->logo_path))) {
                                            $logoUrl = asset('uploads/' . $settings->logo_path);
                                        } elseif (file_exists(public_path('storage/' . $settings->logo_path))) {
                                            $logoUrl = asset('storage/' . $settings->logo_path);
                                        } elseif (file_exists(public_path($settings->logo_path))) {
                                            $logoUrl = asset($settings->logo_path);
                                        }
                                    @endphp
                                    @if ($logoUrl)
                                        <img src="{{ $logoUrl }}" class="h-16 mb-4 object-contain"
                                            alt="Logo">
                                    @endif
                                @endif
                                <h1 class="text-xl font-bold text-neutral-900">
                                    {{ $viewingInvoice->company_snapshot['company_name'] ?? 'Freelancer CRM' }}</h1>
                                @if ($settings)
                                    <div class="text-xs text-neutral-500 mt-1 leading-relaxed">
                                        {{ $viewingInvoice->company_snapshot['company_email'] }}<br>
                                        @if ($viewingInvoice->company_snapshot['company_address'])
                                            {{ $viewingInvoice->company_snapshot['company_address'] }}<br>
                                        @endif
                                        @if ($viewingInvoice->company_snapshot['company_website'])
                                            {{ $viewingInvoice->company_snapshot['company_website'] }}<br>
                                        @endif
                                        @if ($viewingInvoice->company_snapshot['tax_id'])
                                            Tax ID: {{ $viewingInvoice->company_snapshot['tax_id'] }}
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="w-1/2 text-right">
                                <div class="text-4xl font-light text-neutral-300 uppercase tracking-widest mb-2">
                                    Invoice
                                </div>
                                <flux:badge size="sm"
                                    :color="$viewingInvoice->invoice_status === 'paid' ? 'green' : 'neutral'"
                                    class="mb-4">
                                    {{ ucfirst($viewingInvoice->invoice_status) }}
                                </flux:badge>

                                <table class="ml-auto text-sm text-neutral-600">
                                    <tr>
                                        <td class="pr-4 font-bold text-neutral-800">Invoice #:</td>
                                        <td>{{ $viewingInvoice->invoice_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-4 font-bold text-neutral-800">Date:</td>
                                        <td>{{ \Carbon\Carbon::parse($viewingInvoice->issue_date)->format('M d, Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-4 font-bold text-neutral-800">Due Date:</td>
                                        <td>{{ \Carbon\Carbon::parse($viewingInvoice->due_date)->format('M d, Y') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        {{-- Body --}}
                        <div class="px-10 py-8 flex-1">
                            <div class="mb-10">
                                <h3 class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-2">Bill To
                                </h3>
                                @if ($viewingInvoice->client)
                                    <div class="text-lg font-bold text-neutral-900">
                                        {{ $viewingInvoice->client_snapshot['client_name'] }}</div>
                                    <div class="text-sm text-neutral-600">
                                        {{ $viewingInvoice->client->client_email }}<br>
                                        @if ($viewingInvoice->billing_address)
                                            {!! nl2br(e($viewingInvoice->billing_address)) !!}
                                        @endif
                                    </div>
                                @else
                                    <div class="text-neutral-500 italic">Unknown Client</div>
                                @endif
                            </div>

                            {{-- Items Table --}}
                            <table class="w-full mb-8">
                                <thead>
                                    <tr class="bg-neutral-900 text-white text-xs uppercase tracking-wider">
                                        <th class="px-4 py-3 text-left font-semibold rounded-l-md">Description</th>
                                        <th class="px-4 py-3 text-right font-semibold">Qty</th>
                                        <th class="px-4 py-3 text-right font-semibold">Price</th>
                                        <th class="px-4 py-3 text-right font-semibold rounded-r-md">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-neutral-100">
                                    @foreach ($viewingInvoice->items as $item)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="font-bold text-neutral-900 text-sm">
                                                    {{ $item->description }}</div>
                                            </td>
                                            <td class="px-4 py-3 text-right text-sm text-neutral-600">
                                                {{ $item->quantity }}</td>
                                            <td class="px-4 py-3 text-right text-sm text-neutral-600">
                                                {{ number_format($item->unit_price, 2) }}</td>
                                            <td class="px-4 py-3 text-right font-bold text-neutral-900 text-sm">
                                                {{ number_format($item->line_total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Totals --}}
                            <div class="flex justify-end mb-12">
                                <div class="w-1/2 md:w-1/3">
                                    <div
                                        class="flex justify-between py-2 text-sm text-neutral-600 border-b border-neutral-100">
                                        <span>Subtotal</span>
                                        <span>{{ $viewingInvoice->currency->code }}
                                            {{ number_format($viewingInvoice->subtotal, 2) }}</span>
                                    </div>

                                    @php
                                        $metadata = $viewingInvoice->metadata ?? [];
                                        $discountTotal = $viewingInvoice->discount_total;
                                        $lateFeeTotal = $metadata['late_fee_total'] ?? 0;
                                    @endphp

                                    @if ($discountTotal > 0)
                                        <div
                                            class="flex justify-between py-2 text-sm text-red-500 border-b border-neutral-100">
                                            <span>Discount</span>
                                            <span>-{{ $viewingInvoice->currency->code }}
                                                {{ number_format($discountTotal, 2) }}</span>
                                        </div>
                                    @endif

                                    @if ($viewingInvoice->tax_total > 0)
                                        <div
                                            class="flex justify-between py-2 text-sm text-neutral-600 border-b border-neutral-100">
                                            <span>Tax
                                                ({{ number_format($metadata['tax_rate'] ?? ($viewingInvoice->tax_rate ?? 0), 2) }}%)</span>
                                            <span>{{ $viewingInvoice->currency->code }}
                                                {{ number_format($viewingInvoice->tax_total, 2) }}</span>
                                        </div>
                                    @endif

                                    @if ($lateFeeTotal > 0)
                                        <div
                                            class="flex justify-between py-2 text-sm text-yellow-600 border-b border-neutral-100">
                                            <span>Late Fee</span>
                                            <span>+{{ $viewingInvoice->currency->code }}
                                                {{ number_format($lateFeeTotal, 2) }}</span>
                                        </div>
                                    @endif

                                    <div
                                        class="flex justify-between py-3 text-lg font-bold text-neutral-900 border-t border-neutral-900 mt-[-1px]">
                                        <span>Total</span>
                                        <span>{{ $viewingInvoice->currency->code }}
                                            {{ number_format($viewingInvoice->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer Info formed as columns --}}
                            <div class="grid grid-cols-2 gap-8 pt-6 border-t border-neutral-100">
                                {{-- <div>
                                    @if ($settings && ($settings->bank_details || $settings->payment_methods))
                                        <div class="mb-4">
                                            <h4
                                                class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-2">
                                                Payment Details</h4>
                                            @if ($settings->bank_details)
                                                <div class="text-xs text-neutral-600 space-y-1 mb-2">
                                                    @foreach ($settings->bank_details as $detail)
                                                        <div>{{ $detail }}</div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            @if ($settings->payment_methods)
                                                <div class="text-xs text-neutral-500 italic">
                                                    Accepted: {{ implode(', ', $settings->payment_methods) }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div> --}}
                                <div class="text-right">
                                    @if ($viewingInvoice->notes)
                                        <div class="mb-4">
                                            <h4
                                                class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-1">
                                                Notes</h4>
                                            <p class="text-xs text-neutral-600">{{ $viewingInvoice->notes }}</p>
                                        </div>
                                    @endif
                                    @if ($viewingInvoice->terms)
                                        <div>
                                            <h4
                                                class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-1">
                                                Terms</h4>
                                            <p class="text-xs text-neutral-600">{{ $viewingInvoice->terms }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Default Footer --}}
                        @if ($viewingInvoice && $viewingInvoice->default_footer)
                            <div
                                class="bg-neutral-50 px-10 py-4 border-t border-neutral-200 text-center text-xs text-neutral-400">
                                {{ $viewingInvoice->default_footer }}

                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center text-neutral-500 py-10">No invoice selected.</div>
                @endif
            </div>

            <div class="flex justify-center gap-3 mt-6">
                @if ($viewingInvoice)
                    <x-primary-button wire:click="downloadPdf({{ $viewingInvoice->id }})"
                        wire:loading.attr="disabled"
                        class="flex items-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-200 active:scale-[0.97]">

                        {{-- Spinner --}}
                        <svg wire:loading wire:target="downloadPdf({{ $viewingInvoice->id }})"
                            class="size-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"
                                class="opacity-25" />
                            <path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                        </svg>

                        {{-- Download Icon --}}
                        <flux:icon.arrow-down-tray wire:loading.remove
                            wire:target="downloadPdf({{ $viewingInvoice->id }})" class="size-4" />

                        {{-- Label --}}
                        <span wire:loading.remove wire:target="downloadPdf({{ $viewingInvoice->id }})">
                            Download PDF
                        </span>

                        <span wire:loading wire:target="downloadPdf({{ $viewingInvoice->id }})">
                            Generating…
                        </span>

                    </x-primary-button>
                @endif
                <flux:modal.close>
                    <x-secondary-button>Close Preview</x-secondary-button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>


    {{-- Edit Invoice Modal ORIGINAL --}}
    <flux:modal name="edit-invoice-modal"
        class="min-h-[600px] w-full md:w-auto md:max-w-3xl !bg-white dark:!bg-neutral-800">
        <div>
            <div wire:loading wire:target="edit">
                <div class="flex justify-center p-8">
                    <flux:icon.loading />
                </div>
            </div>

            <div wire:loading.remove wire:target="edit">
                @if ($editingInvoice)
                    <div class="space-y-6">
                        <flux:heading size="lg"
                            class="flex items-center gap-3 font-semibold text-gray-900 dark:text-gray-100">

                            <!-- Label -->
                            <span
                                class="text-xs font-medium tracking-widest uppercase text-gray-500 dark:text-gray-400">
                                Invoice
                            </span>

                            <!-- Divider -->
                            <span class="text-gray-300 dark:text-gray-600">/</span>

                            <!-- Invoice Number -->
                            <span class="text-base font-bold text-gray-900 dark:text-white">
                                #{{ $editingInvoice->invoice_number }}
                            </span>

                            <!-- Status Badge -->
                            <span
                                class="text-xs font-medium px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                Editing
                            </span>

                        </flux:heading>

                        <x-hr-divider />

                        <form wire:submit.prevent="update" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                                <flux:select label="Status" wire:model="invoice_status">
                                    <flux:select.option value="draft">Draft</flux:select.option>
                                    <flux:select.option value="sent">Sent</flux:select.option>
                                    <flux:select.option value="paid">Paid</flux:select.option>
                                    <flux:select.option value="partially_paid">Partially Paid</flux:select.option>
                                    <flux:select.option value="overdue">Overdue</flux:select.option>
                                    <flux:select.option value="void">Void</flux:select.option>
                                    <flux:select.option value="canceled">Canceled</flux:select.option>
                                </flux:select>

                                <flux:select label="Currency" wire:model.live="currency">
                                    @foreach ($currencies as $c)
                                        <flux:select.option value="{{ $c->id }}">
                                            {{ $c->code }} - {{ $c->symbol }}
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>

                                <flux:input type="date" label="Issue Date" wire:model.live="issue_date" />
                                <div>
                                    <flux:input type="date" label="Due Date" wire:model="due_date" />
                                    @if ($due_date_note)
                                        <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">
                                            {{ $due_date_note }}</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Items Editor --}}
                            <div class="border-t border-neutral-200 dark:border-neutral-700 pt-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-medium text-neutral-900 dark:text-white">Items</h3>
                                    <flux:button size="sm" icon="plus" wire:click="addItem">Add Item
                                    </flux:button>
                                </div>

                                <div class="space-y-4 md:space-y-2">
                                    @if (!$invoiceItems)
                                        <div
                                            class="flex flex-col items-center justify-center p-8 text-center border-2 border-dashed rounded-lg border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800/50">
                                            <svg class="w-10 h-10 mb-3 text-neutral-400 dark:text-neutral-500"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                </path>
                                            </svg>

                                            <p class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                                No items on this invoice
                                            </p>
                                            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                                                Get started by adding a new line item.
                                            </p>
                                        </div>
                                    @endif

                                    @foreach ($invoiceItems as $index => $item)
                                        <div class="flex flex-col md:grid md:grid-cols-12 gap-3 md:gap-2 items-center justify-center bg-neutral-100 dark:bg-neutral-900/50 md:bg-transparent p-4 rounded-lg md:rounded-none relative group"
                                            wire:key="item-{{ $index }}">

                                            {{-- Description --}}
                                            <div class="w-full md:col-span-5">
                                                <flux:input placeholder="Description" label="Description"
                                                    class="md:hidden"
                                                    wire:model.blur="invoiceItems.{{ $index }}.description" />
                                                <flux:input placeholder="Description" class="hidden md:block"
                                                    wire:model.blur="invoiceItems.{{ $index }}.description" />
                                            </div>

                                            {{-- Qty & Price Row on Mobile --}}
                                            <div class="flex gap-3 w-full md:contents">
                                                <div class="w-1/2 md:w-auto md:col-span-2">
                                                    <flux:input type="number" label="Qty" placeholder="Qty"
                                                        min="0" step="1" class="md:hidden"
                                                        wire:model.blur="invoiceItems.{{ $index }}.quantity" />
                                                    <flux:input type="number" placeholder="Qty" min="0"
                                                        step="1" class="hidden md:block"
                                                        wire:model.blur="invoiceItems.{{ $index }}.quantity" />
                                                </div>
                                                <div class="w-1/2 md:w-auto md:col-span-2">
                                                    <flux:input type="number" label="Price" placeholder="Price"
                                                        min="0" step="0.01" class="md:hidden"
                                                        wire:model.blur="invoiceItems.{{ $index }}.unit_price" />
                                                    <flux:input type="number" placeholder="Price" min="0"
                                                        step="0.01" class="hidden md:block"
                                                        wire:model.blur="invoiceItems.{{ $index }}.unit_price" />
                                                </div>
                                            </div>

                                            {{-- Total & Delete Row on Mobile --}}
                                            <div
                                                class="flex justify-between items-center w-full md:contents mt-2 md:mt-0">
                                                <div class="md:hidden text-sm text-neutral-500">Total:</div>
                                                <div class="md:col-span-2 flex items-center justify-end h-10 px-3">
                                                    <span class="font-medium tabular-nums text-lg md:text-base">
                                                        {{ number_format($item['line_total'], 2) }}
                                                    </span>
                                                </div>
                                                <div
                                                    class="md:col-span-1 flex justify-end md:justify-center pt-1 absolute top-2 right-2 md:static">
                                                    <button type="button"
                                                        class="text-neutral-400 hover:text-red-500 transition-colors p-2"
                                                        wire:click="removeItem({{ $index }})">
                                                        <flux:icon.trash class="size-5 md:size-4" />
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Totals & Settings --}}
                            <div
                                class="border-t border-neutral-200 dark:border-neutral-700 pt-4 grid grid-cols-1 md:grid-cols-2 gap-8">

                                {{-- Left Side: settings --}}
                                <div class="space-y-4">
                                    <flux:heading size="sm">Settings & Adjustments</flux:heading>

                                    <div class="grid grid-cols-1 gap-6">

                                        <!-- Tax Rate -->
                                        <div class="grid grid-cols-3 items-center gap-4">
                                            <flux:label class="col-span-1">Tax Rate (%)</flux:label>
                                            <flux:input type="number" min="0" step="0.01"
                                                class="col-span-2 w-full" wire:model.blur="tax_rate" />
                                        </div>

                                        <!-- Discount -->
                                        <div class="grid grid-cols-3 items-center gap-4">
                                            <flux:label class="col-span-1">Discount</flux:label>

                                            <div class="col-span-2 flex gap-3">
                                                <flux:input type="number" min="0" step="0.01"
                                                    class="w-full" wire:model.blur="discount_value" />

                                                <flux:select wire:model.live="discount_type" class="w-24">
                                                    <flux:select.option value="percentage">%</flux:select.option>
                                                    <flux:select.option value="fixed">$</flux:select.option>
                                                </flux:select>
                                            </div>
                                        </div>

                                        <!-- Late Fee -->
                                        <div class="grid grid-cols-3 items-center gap-4">
                                            <flux:label class="col-span-1">Late Fee</flux:label>

                                            <div class="col-span-2 flex gap-3">
                                                <flux:input type="number" min="0" step="0.01"
                                                    class="w-full" wire:model.blur="late_fee_value" />

                                                <flux:select wire:model.live="late_fee_type" class="w-24">
                                                    <flux:select.option value="percentage">%</flux:select.option>
                                                    <flux:select.option value="fixed">$</flux:select.option>
                                                </flux:select>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- Right Side: Totals --}}
                                <div class="space-y-2 md:pl-8 border-l border-neutral-100 dark:border-neutral-700">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-neutral-500">Subtotal</span>
                                        <span class="font-medium">{{ number_format($subtotal, 2) }}</span>
                                    </div>

                                    @if ($discount_total > 0)
                                        <div class="flex justify-between text-sm text-red-500">
                                            <span>Discount</span>
                                            <span>-{{ number_format($discount_total, 2) }}</span>
                                        </div>
                                    @endif

                                    <div class="flex justify-between text-sm">
                                        <span class="text-neutral-500">Tax</span>
                                        <span class="font-medium">+{{ number_format($tax_total, 2) }}</span>
                                    </div>

                                    @if ($late_fee_total > 0)
                                        <div class="flex justify-between text-sm text-yellow-600">
                                            <span>Late Fee</span>
                                            <span>+{{ number_format($late_fee_total, 2) }}</span>
                                        </div>
                                    @endif

                                    <div
                                        class="flex justify-between text-base font-bold text-neutral-900 dark:text-white pt-2 border-t border-neutral-200 dark:border-neutral-700 mt-2">
                                        <span>Total</span>
                                        <span>{{ $editingInvoice->currency->symbol }}
                                            {{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>


                            <div
                                class="flex justify-end gap-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                                <flux:modal.close>
                                    <x-secondary-button variant="ghost"
                                        wire:click="$dispatch('close-modal', 'edit-invoice-modal')">close</x-secondary-button>
                                </flux:modal.close>
                                <x-primary-button type="submit">Save Changes</x-primary-button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="text-center text-neutral-500">No invoice selected.</div>
                @endif
            </div>
        </div>
    </flux:modal>
</div>
