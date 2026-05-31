<?php

namespace App\Support;

class PpdbFieldLabels
{
    public static function registrationType(?string $value): string
    {
        if (! $value) {
            return '-';
        }

        return PpdbFormOptions::registrationTypes()[$value] ?? $value;
    }

    public static function yesNo(mixed $value): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'Ya' : 'Tidak';
    }

    public static function list(?array $items): string
    {
        if (! $items || ! count($items)) {
            return '-';
        }

        return implode(', ', $items);
    }

    public static function dash(mixed $value): string
    {
        return filled($value) ? (string) $value : '-';
    }

    public static function date(?\DateTimeInterface $value): string
    {
        return $value?->format('d/m/Y') ?? '-';
    }
}
