<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Invoice #{{ $invoice->invoice_number }}</h1>
    <p>Project: {{ $invoice->project->name }}</p>
    <p>Client: {{ $invoice->client->client_name }}</p>
    <p>Status: {{ $invoice->invoice_status }}</p>
    <p>Total: {{ $invoice->total }} {{ $invoice->currency }}</p>
    <!-- TODO: Implement full invoice details view -->
</div>
