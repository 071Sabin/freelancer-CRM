@props(['invoice_status', 'due_date'])

@php
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Automatic Overdue Detection
|--------------------------------------------------------------------------
*/
if (!in_array($invoice_status, ['paid','void','canceled']) && !empty($due_date)) {
    if (Carbon::parse($due_date)->isPast()) {
        $invoice_status = 'overdue';
    }
}

/*
|--------------------------------------------------------------------------
| Professional Status Map
|--------------------------------------------------------------------------
*/

$map = [

    'draft' => [
        'class' => 'bg-neutral-100 text-neutral-700 ring-1 ring-neutral-300
                    dark:bg-neutral-800 dark:text-neutral-300 dark:ring-neutral-700'
    ],

    'sent' => [
        'class' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200
                    dark:bg-blue-900/20 dark:text-blue-300 dark:ring-blue-800'
    ],

    'partially_paid' => [
        'class' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200
                    dark:bg-amber-900/20 dark:text-amber-300 dark:ring-amber-800'
    ],

    'paid' => [
        'class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200
                    dark:bg-emerald-900/20 dark:text-emerald-300 dark:ring-emerald-800'
    ],

    'overdue' => [
        'class' => 'bg-red-50 text-red-700 ring-1 ring-red-200
                    dark:bg-red-900/20 dark:text-red-300 dark:ring-red-800'
    ],

    'void' => [
        'class' => 'bg-zinc-100 text-zinc-700 ring-1 ring-zinc-300
                    dark:bg-zinc-800 dark:text-zinc-300 dark:ring-zinc-700'
    ],

    'canceled' => [
        'class' => 'bg-slate-100 text-slate-700 ring-1 ring-slate-300
                    dark:bg-slate-800 dark:text-slate-300 dark:ring-slate-700'
    ],
];

$config = $map[$invoice_status] ?? $map['draft'];

$label = str($invoice_status)->replace('_',' ')->title();
@endphp


<span
    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
           transition-colors duration-150
           {{ $config['class'] }}">
    {{ $label }}
</span>