<div class="">

    <x-main-heading title="Invoices" subtitle="Create, send, and track invoices with clear payment status and totals." />

    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif

    {{-- main cards for details --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

        <x-dashboard-card heading="Total Invoices" value="0" dataOverTime="All time"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v7.5m2.25-6.466a9.016 9.016 0 0 0-3.461-.203c-.536.072-.974.478-1.021 1.017a4.559 4.559 0 0 0-.018.402c0 .464.336.844.775.994l2.95 1.012c.44.15.775.53.775.994 0 .136-.006.27-.018.402-.047.539-.485.945-1.021 1.017a9.077 9.077 0 0 1-3.461-.203M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>'
            dataColor="text-neutral-400 dark:text-neutral-500" />

        <x-dashboard-card heading="Paid Invoices" value="0" dataOverTime="Successfully paid"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>'
            dataColor="text-emerald-600 dark:text-emerald-500" />

        <x-dashboard-card heading="Outstanding" value="$0.00" dataOverTime="Awaiting payment"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-3h6"/></svg>'
            dataColor="text-amber-600 dark:text-amber-500" />

        <x-dashboard-card heading="Overdue" value="0" dataOverTime="Past due date"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>'
            dataColor="text-red-600 dark:text-red-500" />
    </div>



    <div class="flex flex-col sm:flex-row justify-end items-center my-3 gap-4">
        <flux:modal.trigger name="create-invoice">
            <x-primary-button class="flex gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd"
                        d="M19.5 21a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3h-5.379a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H4.5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h15Zm-6.75-10.5a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V10.5Z"
                        clip-rule="evenodd" />
                </svg>
                Create invoice
            </x-primary-button>
        </flux:modal.trigger>
        <a href="{{ route('invoices.settings.general') }}" wire:navigate
            class="text-zinc-500 hover:text-zinc-900 dark:hover:text-white">
            <flux:icon.cog-6-tooth />
        </a>
    </div>

    <div>
        <flux:modal name="create-invoice" class="max-w-lg">
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

                <flux:select label="Client" wire:model="client_id" placeholder="Select client">
                    @foreach ($clients as $client)
                        <flux:select.option value="{{ $client->id }}">
                            {{ $client->client_name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select label="Project" wire:model="project_id" placeholder="Select project">
                    @foreach ($projects as $project)
                        <flux:select.option value="{{ $project->id }}">
                            {{ $project->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

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

    </div>

    @if ($total_invoices == 0)
        <x-empty-state title="No Invoices Yet"
            subtitle="You haven't created any invoices yet. Start by creating a new invoice to manage your billing.">
            <x-slot:icon>
                <i class="bi bi-file-text text-2xl"></i>
            </x-slot:icon>
        </x-empty-state>
    @else
        <livewire:invoices.invoice-table />
    @endif

    {{-- View Invoice Modal --}}
    <flux:modal name="view-invoice-modal"
        class="min-h-[600px] w-full md:min-w-[900px] !bg-neutral-100 dark:!bg-neutral-900 p-8">
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
                                        <img src="{{ $logoUrl }}" class="h-16 mb-4 object-contain" alt="Logo">
                                    @endif
                                @endif
                                <h1 class="text-xl font-bold text-neutral-900">
                                    {{ $settings->company_name ?? 'Freelancer CRM' }}</h1>
                                @if ($settings)
                                    <div class="text-xs text-neutral-500 mt-1 leading-relaxed">
                                        {{ $settings->company_email }}<br>
                                        @if ($settings->company_address)
                                            {{ implode(', ', $settings->company_address) }}<br>
                                        @endif
                                        @if ($settings->company_website)
                                            {{ $settings->company_website }}<br>
                                        @endif
                                        @if ($settings->tax_id)
                                            Tax ID: {{ $settings->tax_id }}
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="w-1/2 text-right">
                                <div class="text-4xl font-light text-neutral-300 uppercase tracking-widest mb-2">Invoice
                                </div>
                                <flux:badge size="sm"
                                    :color="$viewingInvoice->invoice_status === 'paid' ? 'green' : 'zinc'"
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
                                        {{ $viewingInvoice->client->client_name }}</div>
                                    <div class="text-sm text-neutral-600">
                                        {{ $viewingInvoice->client->client_email }}<br>
                                        @if ($viewingInvoice->client->billing_address)
                                            {!! nl2br(e($viewingInvoice->client->billing_address)) !!}
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
                                        <span>{{ $viewingInvoice->currency }}
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
                                            <span>-{{ $viewingInvoice->currency }}
                                                {{ number_format($discountTotal, 2) }}</span>
                                        </div>
                                    @endif

                                    @if ($viewingInvoice->tax_total > 0)
                                        <div
                                            class="flex justify-between py-2 text-sm text-neutral-600 border-b border-neutral-100">
                                            <span>Tax
                                                ({{ number_format($metadata['tax_rate'] ?? ($viewingInvoice->tax_rate ?? 0), 2) }}%)</span>
                                            <span>{{ $viewingInvoice->currency }}
                                                {{ number_format($viewingInvoice->tax_total, 2) }}</span>
                                        </div>
                                    @endif

                                    @if ($lateFeeTotal > 0)
                                        <div
                                            class="flex justify-between py-2 text-sm text-yellow-600 border-b border-neutral-100">
                                            <span>Late Fee</span>
                                            <span>+{{ $viewingInvoice->currency }}
                                                {{ number_format($lateFeeTotal, 2) }}</span>
                                        </div>
                                    @endif

                                    <div
                                        class="flex justify-between py-3 text-lg font-bold text-neutral-900 border-t border-neutral-900 mt-[-1px]">
                                        <span>Total</span>
                                        <span>{{ $viewingInvoice->currency }}
                                            {{ number_format($viewingInvoice->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer Info formed as columns --}}
                            <div class="grid grid-cols-2 gap-8 pt-6 border-t border-neutral-100">
                                <div>
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
                                </div>
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
                        @if ($settings && $settings->default_footer)
                            <div
                                class="bg-neutral-50 px-10 py-4 border-t border-neutral-200 text-center text-xs text-neutral-400">
                                {{ $settings->default_footer }}
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
                        wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed">

                        {{-- Loading State --}}
                        <div wire:loading wire:target="downloadPdf({{ $viewingInvoice->id }})"
                            class="flex items-center">
                            <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Processing...
                        </div>

                        {{-- Default State --}}
                        <div wire:loading.remove wire:target="downloadPdf({{ $viewingInvoice->id }})"
                            class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Download PDF
                        </div>
                    </x-primary-button>
                @endif
                <flux:modal.close>
                    <x-secondary-button>Close Preview</x-secondary-button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>

    {{-- Edit Invoice Modal --}}
    <flux:modal name="edit-invoice-modal"
        class="min-h-[600px] w-full md:w-auto md:max-w-5xl !bg-white dark:!bg-neutral-800">
        <div>
            <div wire:loading wire:target="edit">
                <div class="flex justify-center p-8">
                    <flux:icon.loading />
                </div>
            </div>

            <div wire:loading.remove wire:target="edit">
                @if ($editingInvoice)
                    <div class="space-y-6">
                        <flux:heading size="lg">Edit Invoice #{{ $editingInvoice->invoice_number }}
                        </flux:heading>

                        <form wire:submit.prevent="update" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="col-span-1 md:col-span-2">
                                    <flux:select label="Status" wire:model="invoice_status">
                                        <flux:select.option value="draft">Draft</flux:select.option>
                                        <flux:select.option value="sent">Sent</flux:select.option>
                                        <flux:select.option value="paid">Paid</flux:select.option>
                                        <flux:select.option value="partially_paid">Partially Paid</flux:select.option>
                                        <flux:select.option value="overdue">Overdue</flux:select.option>
                                        <flux:select.option value="void">Void</flux:select.option>
                                        <flux:select.option value="canceled">Canceled</flux:select.option>
                                    </flux:select>
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <flux:select label="Currency" wire:model="currency">
                                        <flux:select.option value="USD">USD</flux:select.option>
                                        <flux:select.option value="EUR">EUR</flux:select.option>
                                        <flux:select.option value="GBP">GBP</flux:select.option>
                                        <flux:select.option value="AUD">AUD</flux:select.option>
                                        <flux:select.option value="CAD">CAD</flux:select.option>
                                        <flux:select.option value="NPR">NPR</flux:select.option>
                                    </flux:select>
                                </div>
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
                                    {{-- Headers (Desktop Only) --}}
                                    <div
                                        class="hidden md:grid grid-cols-12 gap-2 mb-2 text-xs font-medium text-neutral-500 uppercase tracking-wider px-2">
                                        <div class="col-span-5">Description</div>
                                        <div class="col-span-2">Qty</div>
                                        <div class="col-span-2">Price</div>
                                        <div class="col-span-2 text-right">Total</div>
                                        <div class="col-span-1"></div>
                                    </div>

                                    @foreach ($invoiceItems as $index => $item)
                                        <div class="flex flex-col md:grid md:grid-cols-12 gap-3 md:gap-2 items-start bg-neutral-50 dark:bg-neutral-900/50 md:bg-transparent p-4 md:p-0 rounded-lg md:rounded-none relative group"
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

                                    <div class="grid grid-cols-2 gap-4">
                                        <flux:input type="number" label="Tax Rate (%)" min="0"
                                            step="0.01" wire:model.blur="tax_rate" />
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <flux:label>Discount</flux:label>
                                            <div class="flex">
                                                <div class="w-2/3">
                                                    <flux:input type="number" min="0" step="0.01"
                                                        wire:model.blur="discount_value" />
                                                </div>
                                                <div class="w-1/3 ml-2">
                                                    <flux:select wire:model.live="discount_type" class="min-w-[80px]">
                                                        <flux:select.option value="percentage">%</flux:select.option>
                                                        <flux:select.option value="fixed">$</flux:select.option>
                                                    </flux:select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-y-2">
                                            <flux:label>Late Fee</flux:label>
                                            <div class="flex">
                                                <div class="w-2/3">
                                                    <flux:input type="number" min="0" step="0.01"
                                                        wire:model.blur="late_fee_value" />
                                                </div>
                                                <div class="w-1/3 ml-2">
                                                    <flux:select wire:model.live="late_fee_type" class="min-w-[80px]">
                                                        <flux:select.option value="percentage">%</flux:select.option>
                                                        <flux:select.option value="fixed">$</flux:select.option>
                                                    </flux:select>
                                                </div>
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
                                        <span>{{ $editingInvoice->currency ?? '$' }}
                                            {{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>


                            <div
                                class="flex justify-end gap-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                                <flux:modal.close>
                                    <x-secondary-button variant="ghost"
                                        wire:click="$dispatch('close-modal', 'edit-invoice-modal')">Cancel</x-secondary-button>
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
