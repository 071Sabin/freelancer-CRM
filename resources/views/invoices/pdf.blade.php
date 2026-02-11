<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 30px;
            overflow: hidden;
        }

        .company-logo {
            float: left;
            max-height: 80px;
        }

        .invoice-title {
            float: right;
            font-size: 24px;
            font-weight: bold;
            color: #555;
            text-transform: uppercase;
        }

        .meta-info {
            margin-top: 10px;
            text-align: right;
            clear: both;
        }

        .meta-info table {
            float: right;
        }

        .meta-info td {
            text-align: right;
            padding: 2px 0 2px 15px;
        }

        .addresses {
            margin-bottom: 30px;
            overflow: hidden;
        }

        .from-address {
            float: left;
            width: 48%;
        }

        .to-address {
            float: right;
            width: 48%;
        }

        .address-title {
            font-weight: bold;
            color: #777;
            text-transform: uppercase;
            font-size: 11px;
            margin-bottom: 5px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .table-container {
            margin-bottom: 30px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
        }

        table.items th {
            text-align: left;
            padding: 10px;
            background-color: #f8f9fa;
            border-bottom: 2px solid #ddd;
            font-weight: bold;
            color: #555;
        }

        table.items td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            float: right;
            width: 40%;
            margin-bottom: 30px;
        }

        .totals table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals td {
            padding: 5px 0;
            text-align: right;
        }

        .totals .total-row td {
            font-weight: bold;
            border-top: 2px solid #ddd;
            padding-top: 10px;
            font-size: 16px;
        }

        .notes {
            clear: both;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .notes-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
            color: #777;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            @if ($settings && $settings->logo_path)
                <img src="{{ public_path('storage/' . $settings->logo_path) }}" class="company-logo" alt="Logo">
            @else
                <h1 style="float: left; margin: 0;">{{ $settings->company_name ?? 'Freelancer CRM' }}</h1>
            @endif

            <div class="invoice-title">Invoice</div>
        </div>

        <div class="meta-info">
            <table>
                <tr>
                    <td><strong>Invoice #:</strong></td>
                    <td>{{ $invoice->invoice_number }}</td>
                </tr>
                <tr>
                    <td><strong>Date:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Due Date:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</td>
                </tr>
            </table>
        </div>

        <div class="addresses">
            <div class="from-address">
                <div class="address-title">From</div>
                @if ($settings)
                    <strong>{{ $settings->company_name }}</strong><br>
                    {{ $settings->company_email }}<br>
                    @if ($settings->company_address)
                        @foreach ($settings->company_address as $line)
                            {{ $line }}<br>
                        @endforeach
                    @endif
                @else
                    <strong>You (Freelancer)</strong>
                @endif
            </div>

            <div class="to-address">
                <div class="address-title">Bill To</div>
                @if ($invoice->client)
                    <strong>{{ $invoice->client->client_name }}</strong><br>
                    {{ $invoice->client->client_email }}<br>
                    @if ($invoice->client->billing_address)
                        {!! nl2br(e($invoice->client->billing_address)) !!}
                    @endif
                @else
                    <strong>Unknown Client</strong><br>
                    <em>Client details unavailable</em>
                @endif
            </div>
        </div>

        <div class="table-container">
            <table class="items">
                <thead>
                    <tr>
                        <th width="50%">Description</th>
                        <th width="10%" class="text-right">Qty</th>
                        <th width="20%" class="text-right">Price</th>
                        <th width="20%" class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->description }}</strong>
                                @if ($item->name)
                                    <br><span style="color: #777; font-size: 12px;">{{ $item->name }}</span>
                                @endif
                            </td>
                            <td class="text-right">{{ $item->quantity }}</td>
                            <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-right">{{ number_format($item->line_total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td>{{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                @if ($invoice->tax_total > 0)
                    <tr>
                        <td>Tax ({{ number_format($invoice->tax_rate, 2) }}%):</td>
                        <td>{{ $invoice->currency }} {{ number_format($invoice->tax_total, 2) }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td>Total:</td>
                    <td>{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="notes">
            @if ($invoice->notes)
                <div class="notes-title">Notes</div>
                <p>{{ $invoice->notes }}</p>
            @endif

            @if ($invoice->terms)
                <div class="notes-title" style="margin-top: 15px;">Terms & Conditions</div>
                <p>{{ $invoice->terms }}</p>
            @endif
        </div>

        @if ($settings && $settings->default_footer)
            <div class="footer">
                {{ $settings->default_footer }}
            </div>
        @endif
    </div>
</body>

</html>
