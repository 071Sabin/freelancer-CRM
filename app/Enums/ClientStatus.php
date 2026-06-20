<?php

namespace App\Enums;

enum ClientStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case LEAD = 'lead';

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])->toArray();
    }

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::LEAD => 'Lead',
        };
    }

    public function colourClass(): string
    {
        return match ($this) {
            self::ACTIVE => 'bg-green-100 text-green-700 border border-green-400 dark:bg-green-900/30 dark:text-green-300 dark:border-green-500',
            self::INACTIVE => 'bg-red-100 text-red-700 border border-red-400 dark:bg-red-900/30 dark:text-red-300 dark:border-red-500',
            self::LEAD => 'bg-amber-100 text-amber-700 border border-amber-400 dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-500',
        };
    }
}
