<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        /* Base / Reset */
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
            color: #171717;
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            vertical-align: top;
            text-align: left;
        }

        /* Layout Utilities */
        .w-full {
            width: 100%;
        }

        .w-half {
            width: 50%;
        }

        .h-16 {
            height: 60px;
        }

        /* Approx h-16 */

        .p-8 {
            padding: 32px;
        }

        .p-10 {
            padding: 40px;
        }

        .px-4 {
            padding-left: 16px;
            padding-right: 16px;
        }

        .py-2 {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .py-3 {
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .py-4 {
            padding-top: 16px;
            padding-bottom: 16px;
        }

        .py-8 {
            padding-top: 32px;
            padding-bottom: 32px;
        }

        .pt-6 {
            padding-top: 24px;
        }

        .pb-1 {
            padding-bottom: 4px;
        }

        .pl-4 {
            padding-left: 16px;
        }

        .m-0 {
            margin: 0;
        }

        .mt-1 {
            margin-top: 4px;
        }

        .mt-2 {
            margin-top: 8px;
        }

        .mt-8 {
            margin-top: 32px;
        }

        .mt-12 {
            margin-top: 48px;
        }

        .mb-1 {
            margin-bottom: 4px;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .mb-4 {
            margin-bottom: 16px;
        }

        .mb-6 {
            margin-bottom: 24px;
        }

        .mb-10 {
            margin-bottom: 40px;
        }

        /* Flex-like Helpers (Table based) */
        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .align-top {
            vertical-align: top;
        }

        /* Typography */
        .font-bold {
            font-weight: bold;
        }

        .font-normal {
            font-weight: normal;
        }

        .font-light {
            font-weight: 300;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .tracking-wide {
            letter-spacing: 0.05em;
        }

        .tracking-widest {
            letter-spacing: 0.1em;
        }

        .text-xs {
            font-size: 12px;
        }

        .text-sm {
            font-size: 14px;
        }

        .text-lg {
            font-size: 18px;
        }

        .text-xl {
            font-size: 20px;
        }

        .text-4xl {
            font-size: 36px;
        }

        .leading-normal {
            line-height: 1.5;
        }

        .leading-relaxed {
            line-height: 1.625;
        }

        .italic {
            font-style: italic;
        }

        /* Colors */
        .text-white {
            color: #ffffff;
        }

        .text-neutral-900 {
            color: #171717;
        }

        .text-neutral-600 {
            color: #525252;
        }

        .text-neutral-500 {
            color: #737373;
        }

        .text-neutral-400 {
            color: #a3a3a3;
        }

        .text-neutral-300 {
            color: #d4d4d4;
        }

        .text-red-500 {
            color: #ef4444;
        }

        .text-yellow-600 {
            color: #d97706;
        }

        .bg-neutral-50 {
            background-color: #fafafa;
        }

        .bg-neutral-900 {
            background-color: #171717;
        }

        /* Borders */
        .border-t {
            border-top: 1px solid #e5e5e5;
        }

        .border-b {
            border-bottom: 1px solid #e5e5e5;
        }

        /* neutral-200ish */
        .border-neutral-100 {
            border-color: #f5f5f5;
        }

        /* Specific Components */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .bg-green-100 {
            background-color: #d1fae5;
            color: #065f46;
        }

        .bg-gray-100 {
            background-color: #f4f4f5;
            color: #3f3f46;
        }

        .bg-red-100 {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Table Radius Fix */
        .rounded-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .rounded-l {
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
        }

        .rounded-r {
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }
    </style>
</head>

<body class="bg-white text-neutral-900">

    <!-- Header -->
    <div class="bg-neutral-50 p-10 border-b">
        <table>
            <tr>
                <td class="w-half">
                    @if ($settings && $settings->logo_path)
                        @php
                            $logoUrl = null;
                            if (file_exists(public_path('uploads/' . $settings->logo_path))) {
                                $logoUrl = public_path('uploads/' . $settings->logo_path);
                            } elseif (file_exists(public_path('storage/' . $settings->logo_path))) {
                                $logoUrl = public_path('storage/' . $settings->logo_path);
                            } elseif (file_exists(public_path($settings->logo_path))) {
                                $logoUrl = public_path($settings->logo_path);
                            }
                        @endphp
                        @if ($logoUrl)
                            <img src="{{ $logoUrl }}" class="h-16 mb-4" style="width: auto;">
                        @endif
                    @endif

                    <div class="text-xl font-bold text-neutral-900">{{ $settings->company_name ?? 'Freelancer CRM' }}
                    </div>

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
                </td>

                <td class="w-half text-right align-top">
                    <div class="text-4xl font-light text-neutral-300 uppercase tracking-widest mb-2">Invoice</div>

                    @php
                        $badgeClass = match ($invoice->invoice_status) {
                            'paid' => 'bg-green-100',
                            'overdue' => 'bg-red-100',
                            default => 'bg-gray-100',
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }} mb-4">{{ ucfirst($invoice->invoice_status) }}</span>

                    <table class="w-full mt-2">
                        <tr>
                            <td class="text-right text-neutral-900 font-bold px-4 pb-1">Invoice #:</td>
                            <td class="text-right text-neutral-600 pb-1">{{ $invoice->invoice_number }}</td>
                        </tr>
                        <tr>
                            <td class="text-right text-neutral-900 font-bold px-4 pb-1">Date:</td>
                            <td class="text-right text-neutral-600 pb-1">
                                {{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-right text-neutral-900 font-bold px-4 pb-1">Due Date:</td>
                            <td class="text-right text-neutral-600 pb-1">
                                {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- Content -->
    <div class="p-10">

        <!-- Bill To -->
        <div class="mb-6">
            <div class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-2">Bill To</div>
            @if ($invoice->client)
                <div class="text-lg font-bold text-neutral-900 mb-1">{{ $invoice->client->client_name }}</div>
                <div class="text-sm text-neutral-600">
                    {{ $invoice->client->client_email }}<br>
                    @if ($invoice->client->billing_address)
                        {!! nl2br(e($invoice->client->billing_address)) !!}
                    @endif
                    @if ($invoice->client->tax_id)
                        <br>Tax ID: {{ $invoice->client->tax_id }}
                    @endif
                </div>
            @else
                <div class="text-neutral-500 italic">Unknown Client</div>
            @endif
        </div>

        <!-- Items Table -->
        <table class="w-full rounded-table mb-8">
            <thead>
                <tr class="bg-neutral-900 text-white text-xs uppercase tracking-wide">
                    <th class="py-3 px-4 font-bold rounded-l">Description</th>
                    <th class="py-3 px-4 font-bold text-right w-15">Qty</th>
                    <th class="py-3 px-4 font-bold text-right w-20">Price</th>
                    <th class="py-3 px-4 font-bold text-right rounded-r w-20">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr class="border-b border-neutral-100">
                        <td class="py-3 px-4">
                            <div class="text-sm font-bold text-neutral-900">{{ $item->description }}</div>
                            @if ($item->name)
                                <div class="text-xs text-neutral-500 mt-1">{{ $item->name }}</div>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-sm text-right text-neutral-600">{{ $item->quantity }}</td>
                        <td class="py-3 px-4 text-sm text-right text-neutral-600">
                            {{ number_format($item->unit_price, 2) }}</td>
                        <td class="py-3 px-4 text-sm text-right font-bold text-neutral-900">
                            {{ number_format($item->line_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <table class="w-full mb-10">
            <tr>
                <td class="w-half"></td> <!-- Spacer -->
                <td class="w-half">
                    <table class="w-full">
                        <tr>
                            <td class="py-2 text-neutral-600 border-b border-neutral-100">Subtotal</td>
                            <td class="py-2 text-right text-neutral-900 font-medium border-b border-neutral-100">
                                {{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</td>
                        </tr>

                        @php
                            $metadata = $invoice->metadata ?? [];
                            $discountTotal = $invoice->discount_total;
                            $lateFeeTotal = $metadata['late_fee_total'] ?? 0;
                        @endphp

                        @if ($discountTotal > 0)
                            <tr>
                                <td class="py-2 text-red-500 border-b border-neutral-100">Discount</td>
                                <td class="py-2 text-right text-red-500 font-medium border-b border-neutral-100">
                                    -{{ $invoice->currency }} {{ number_format($discountTotal, 2) }}</td>
                            </tr>
                        @endif

                        @if ($invoice->tax_total > 0)
                            <tr>
                                <td class="py-2 text-neutral-600 border-b border-neutral-100">Tax
                                    ({{ number_format($metadata['tax_rate'] ?? ($invoice->tax_rate ?? 0), 2) }}%)</td>
                                <td class="py-2 text-right text-neutral-900 font-medium border-b border-neutral-100">
                                    {{ $invoice->currency }} {{ number_format($invoice->tax_total, 2) }}</td>
                            </tr>
                        @endif

                        @if ($lateFeeTotal > 0)
                            <tr>
                                <td class="py-2 text-yellow-600 border-b border-neutral-100">Late Fee</td>
                                <td class="py-2 text-right text-yellow-600 font-medium border-b border-neutral-100">
                                    +{{ $invoice->currency }} {{ number_format($lateFeeTotal, 2) }}</td>
                            </tr>
                        @endif

                        <tr>
                            <td class="py-3 text-lg font-bold text-neutral-900 border-t border-neutral-900 mt-1">Total
                            </td>
                            <td
                                class="py-3 text-lg font-bold text-right text-neutral-900 border-t border-neutral-900 mt-1">
                                {{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="border-t pt-6">
            <table>
                <tr>
                    <td class="w-half align-top pr-8">
                        @if ($settings && ($settings->bank_details || $settings->payment_methods))
                            <div class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-2">Payment
                                Details</div>
                            <div class="text-xs text-neutral-600 leading-relaxed">
                                @if ($settings->bank_details)
                                    @foreach ($settings->bank_details as $detail)
                                        <div>{{ $detail }}</div>
                                    @endforeach
                                @endif

                                @if ($settings->payment_methods)
                                    <div class="italic mt-2">
                                        Accepted: {{ implode(', ', $settings->payment_methods) }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td class="w-half align-top">
                        @if ($invoice->notes)
                            <div class="mb-4">
                                <div class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-2">Notes
                                </div>
                                <div class="text-xs text-neutral-600 leading-relaxed">{{ $invoice->notes }}</div>
                            </div>
                        @endif

                        @if ($invoice->terms)
                            <div>
                                <div class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-2">Terms &
                                    Conditions</div>
                                <div class="text-xs text-neutral-600 leading-relaxed">{{ $invoice->terms }}</div>
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        @if ($settings && $settings->default_footer)
            <div class="mt-12 text-center text-xs text-neutral-400">
                {{ $settings->default_footer }}
            </div>
        @endif

    </div>
</body>

</html>
