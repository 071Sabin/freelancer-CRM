@props(['status', 'due_date'])

@php
    use Carbon\Carbon;

    // 🔥 AUTO OVERDUE DETECTION (enterprise logic)
    if ($status !== 'paid' && $status !== 'void' && $status !== 'canceled') {
        if (!empty($due_date) && Carbon::parse($due_date)->isPast()) {
            $status = 'overdue';
        }
    }

    $map = [

        'draft' => [
            'class' => 'bg-neutral-200 text-neutral-800 dark:bg-neutral-700 dark:text-neutral-200',
            'icon' => '📝'
        ],

        'sent' => [
            'class' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300',
            'icon' => '📤'
        ],

        'partially_paid' => [
            'class' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300',
            'icon' => '💰'
        ],

        'paid' => [
            'class' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300',
            'icon' => '✅'
        ],

        'overdue' => [
            // 👇 PREMIUM GLOW EFFECT
            'class' => 'bg-red-100 text-red-800 ring-1 ring-red-300 dark:bg-red-900/40 dark:text-red-300 dark:ring-red-800',
            'icon' => '⚠️'
        ],

        'void' => [
            'class' => 'bg-zinc-200 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300',
            'icon' => '🚫'
        ],

        'canceled' => [
            'class' => 'bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
            'icon' => '❌'
        ],
    ];

    $config = $map[$status] ?? $map['draft'];

    $label = str($status)->replace('_',' ')->title();
@endphp

<span
    class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium rounded-full transition-all duration-200 hover:scale-105 {{ $config['class'] }}"
>
    <span class="text-[10px]">{{ $config['icon'] }}</span>
    {{ $label }}
</span>
