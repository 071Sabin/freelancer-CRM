<?php

namespace App\Enums;

enum LateFeeType: string
{
    case PERCENT = 'percent';
    case AMOUNT = 'amount';

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])->toArray();
    }

    public function label(): string
    {
        return match ($this) {
            self::PERCENT => 'Percent',
            self::AMOUNT => 'Amount',
        };
    }

    public function colourClass(): string
    {
        return match ($this) {
            self::PERCENT => 'bg-indigo-50 text-indigo-700 ring-indigo-700/10 dark:bg-indigo-400/10 dark:text-indigo-400 dark:ring-indigo-400/30',
            self::AMOUNT => 'bg-teal-50 text-teal-700 ring-teal-700/10 dark:bg-teal-400/10 dark:text-teal-400 dark:ring-teal-400/30',
        };
    }
}
