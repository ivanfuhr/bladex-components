<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Support\Date;

use Illuminate\Support\Carbon;

final class DateFormatter
{
    public static function resolveTimezone(?string $timezone): string
    {
        if (filled($timezone)) {
            return $timezone;
        }

        return (string) config('app.timezone', 'UTC');
    }

    public static function normalizeDateValue(mixed $value, string $mode = 'single'): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_array($value)) {
            if ($mode === 'range') {
                $start = $value['start'] ?? null;
                $end = $value['end'] ?? null;

                if (filled($start) && filled($end)) {
                    return self::toDateString($start).'/'.self::toDateString($end);
                }

                return null;
            }

            return collect($value)->filter()->map(fn (mixed $v) => self::toDateString($v))->implode(',');
        }

        if ($value instanceof DateRange) {
            $start = $value->start()?->format('Y-m-d');
            $end = $value->end()?->format('Y-m-d');

            if ($start && $end) {
                return $start.'/'.$end;
            }
        }

        return is_string($value) ? $value : self::toDateString($value);
    }

    public static function normalizeDateTimeValue(mixed $value, ?string $timezone = null): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_string($value)) {
            return Carbon::parse($value, self::resolveTimezone($timezone))->toIso8601String();
        }

        if ($value instanceof Carbon) {
            return $value->copy()->timezone(self::resolveTimezone($timezone))->toIso8601String();
        }

        return null;
    }

    public static function normalizeTimeValue(mixed $value, bool $withSeconds = false): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_array($value)) {
            $value = collect($value)->first();
        }

        if (! is_string($value)) {
            return null;
        }

        $parts = explode(':', $value);

        if (count($parts) === 2) {
            return $withSeconds ? $value.':00' : $value;
        }

        if (count($parts) === 3) {
            return $withSeconds ? $value : implode(':', array_slice($parts, 0, 2));
        }

        return $value;
    }

    public static function toDateString(mixed $value): string
    {
        if ($value instanceof Carbon) {
            return $value->format('Y-m-d');
        }

        return Carbon::parse($value)->format('Y-m-d');
    }
}
