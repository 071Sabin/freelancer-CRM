<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
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

        /* Utility */
        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .tracking-wide {
            letter-spacing: 0.1em;
        }

        .text-xs {
            font-size: 12px;
        }

        .text-sm {
            font-size: 14px;
        }

        .text-neutral-500 {
            color: #737373;
        }

        .text-neutral-600 {
            color: #525252;
        }

        .text-neutral-400 {
            color: #a3a3a3;
        }

        /* Header */
        .header-bg {
            background-color: #fafafa;
            padding: 40px;
            border-bottom: 1px solid #e5e5e5;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
        }

        .company-logo {
            height: 60px;
            margin-bottom: 15px;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #171717;
        }

        .invoice-label {
            font-size: 36px;
            font-weight: 300;
            color: #d4d4d4;
            /* neutral-300 */
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 10px;
            line-height: 1;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .badge-paid {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-draft {
            background-color: #f4f4f5;
            color: #3f3f46;
        }

        .badge-overdue {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .meta-table {
            float: right;
        }

        .meta-table td {
            padding-bottom: 4px;
            padding-left: 20px;
            text-align: right;
            color: #525252;
        }

        .meta-label {
            font-weight: bold;
            color: #171717;
        }

        /* Content */
        .container {
            padding: 40px;
        }

        .bill-to-label {
            font-size: 12px;
            color: #a3a3a3;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 10px;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            margin-bottom: 40px;
        }

        .items-table th {
            text-align: left;
            padding: 12px 16px;
            background-color: #171717;
            color: #ffffff;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .items-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f5f5f5;
            color: #171717;
        }

        .items-table .desc-cell {
            width: 45%;
        }

        /* Totals */
        .totals-table {
            width: 45%;
            float: right;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 0;
            text-align: right;
            border-bottom: 1px solid #f5f5f5;
            font-size: 14px;
            color: #525252;
        }

        .totals-table td:first-child {
            text-align: left;
        }

        .totals-table td:last-child {
            color: #171717;
            font-weight: 500;
        }

        .total-row td {
            border-top: 1px solid #171717;
            color: #171717;
            font-weight: bold;
            font-size: 18px;
            padding-top: 15px;
            padding-bottom: 0;
            border-bottom: none;
        }

        .text-red {
            color: #ef4444 !important;
        }

        .text-yellow {
            color: #d97706 !important;
        }

        /* Footer */
        .footer-table {
            width: 100%;
            margin-top: 50px;
            border-top: 1px solid #f5f5f5;
            padding-top: 30px;
        }

        .footer-table td {
            vertical-align: top;
        }

        .footer-heading {
            font-size: 12px;
            font-weight: bold;
            color: #a3a3a3;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 10px;
        }

        .footer-content {
            font-size: 12px;
            color: #525252;
            line-height: 1.6;
        }
    </style>
</head>

<body>

    <!-- Header Section -->
    <div class="header-bg">
        <table class="header-table">
            <tr>
                <!-- Left Column: Company Info -->
                <td style="width: 50%;">
                    @if ($settings && $settings->logo_path)
                        <img src="{{ public_path('storage/' . $settings->logo_path) }}" class="company-logo">
                    @endif

                    <div class="company-name">{{ $settings->company_name ?? 'Freelancer CRM' }}</div>

                    @if ($settings)
                        <div class="footer-content" style="margin-top: 5px;">
                            {{ $settings->company_email }}<br>
                            @if ($settings->company_address)
                                @foreach ($settings->company_address as $line)
                                    {{ $line }}<br>
                                @endforeach
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

                <!-- Right Column: Invoice Details -->
                <td style="width: 50%; text-align: right;">
                    <div class="invoice-label">Invoice</div>

                    @php
                        $badgeClass = match ($invoice->invoice_status) {
                            'paid' => 'badge-paid',
                            'overdue' => 'badge-overdue',
                            default => 'badge-draft',
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ ucfirst($invoice->invoice_status) }}</span>

                    <table class="meta-table">
                        <tr>
                            <td class="meta-label">Invoice #:</td>
                            <td>{{ $invoice->invoice_number }}</td>
                        </tr>
                        <tr>
                            <td class="meta-label">Date:</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="meta-label">Due Date:</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- Main Content -->
    <div class="container">

        <!-- Bill To -->
        <div style="margin-bottom: 40px;">
            <div class="bill-to-label">Bill To</div>
            @if ($invoice->client)
                <div style="font-size: 18px; font-weight: bold; color: #171717; margin-bottom: 4px;">
                    {{ $invoice->client->client_name }}
                </div>
                <div class="text-neutral-600" style="font-size: 14px;">
                    {{ $invoice->client->client_email }}<br>
                    @if ($invoice->client->billing_address)
                        {!! nl2br(e($invoice->client->billing_address)) !!}
                    @endif
                    @if ($invoice->client->tax_id)
                        <br>Tax ID: {{ $invoice->client->tax_id }}
                    @endif
                </div>
            @else
                <div class="text-neutral-400 italic">Unknown Client</div>
            @endif
        </div>

        <!-- Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th class="desc-cell">Description</th>
                    <th class="text-right" style="width: 15%;">Qty</th>
                    <th class="text-right" style="width: 20%;">Price</th>
                    <th class="text-right" style="width: 20%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td class="desc-cell">
                            <div style="font-weight: bold;">{{ $item->description }}</div>
                            @if ($item->name)
                                <div style="font-size: 12px; color: #737373; margin-top: 4px;">{{ $item->name }}
                                </div>
                            @endif
                        </td>
                        <td class="text-right text-neutral-600">{{ $item->quantity }}</td>
                        <td class="text-right text-neutral-600">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right font-bold text-neutral-900">{{ number_format($item->line_total, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div style="overflow: hidden;">
            <table class="totals-table">
                <tr>
                    <td>Subtotal</td>
                    <td>{{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</td>
                </tr>

                @php
                    $metadata = $invoice->metadata ?? [];
                    $discountTotal = $invoice->discount_total;
                    $lateFeeTotal = $metadata['late_fee_total'] ?? 0;
                @endphp

                @if ($discountTotal > 0)
                    <tr>
                        <td class="text-red">Discount</td>
                        <td class="text-red">-{{ $invoice->currency }} {{ number_format($discountTotal, 2) }}</td>
                    </tr>
                @endif

                @if ($invoice->tax_total > 0)
                    <tr>
                        <td>Tax ({{ number_format($metadata['tax_rate'] ?? ($invoice->tax_rate ?? 0), 2) }}%)</td>
                        <td>{{ $invoice->currency }} {{ number_format($invoice->tax_total, 2) }}</td>
                    </tr>
                @endif

                @if ($lateFeeTotal > 0)
                    <tr>
                        <td class="text-yellow">Late Fee</td>
                        <td class="text-yellow">+{{ $invoice->currency }} {{ number_format($lateFeeTotal, 2) }}</td>
                    </tr>
                @endif

                <tr class="total-row">
                    <td>Total</td>
                    <td>{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <table class="footer-table">
            <tr>
                <td style="width: 50%;">
                    @if ($settings && ($settings->bank_details || $settings->payment_methods))
                        <div class="footer-heading">Payment Details</div>
                        <div class="footer-content">
                            @if ($settings->bank_details)
                                @foreach ($settings->bank_details as $detail)
                                    <div>{{ $detail }}</div>
                                @endforeach
                            @endif

                            @if ($settings->payment_methods)
                                <div style="margin-top: 8px; font-style: italic; color: #737373;">
                                    Accepted: {{ implode(', ', $settings->payment_methods) }}
                                </div>
                            @endif
                        </div>
                    @endif
                </td>
                <td style="width: 50%;">
                    @if ($invoice->notes)
                        <div class="footer-heading">Notes</div>
                        <div class="footer-content" style="margin-bottom: 20px;">
                            {{ $invoice->notes }}
                        </div>
                    @endif

                    @if ($invoice->terms)
                        <div class="footer-heading">Terms & Conditions</div>
                        <div class="footer-content">
                            {{ $invoice->terms }}
                        </div>
                    @endif
                </td>
            </tr>
        </table>

        @if ($settings && $settings->default_footer)
            <div class="text-center text-neutral-400 text-xs" style="margin-top: 50px;">
                {{ $settings->default_footer }}
            </div>
        @endif

    </div>
</body>

</html>
