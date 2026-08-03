<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Support\Date;

use Illuminate\Support\Carbon;

enum DateRangePreset: string
{
    case Today = 'today';
    case Yesterday = 'yesterday';
    case ThisWeek = 'thisWeek';
    case LastWeek = 'lastWeek';
    case Last7Days = 'last7Days';
    case ThisMonth = 'thisMonth';
    case LastMonth = 'lastMonth';
    case ThisQuarter = 'thisQuarter';
    case LastQuarter = 'lastQuarter';
    case ThisYear = 'thisYear';
    case LastYear = 'lastYear';
    case Last14Days = 'last14Days';
    case Last30Days = 'last30Days';
    case Last3Months = 'last3Months';
    case Last6Months = 'last6Months';
    case YearToDate = 'yearToDate';
    case Tomorrow = 'tomorrow';
    case NextWeek = 'nextWeek';
    case Next7Days = 'next7Days';
    case NextMonth = 'nextMonth';
    case NextQuarter = 'nextQuarter';
    case NextYear = 'nextYear';
    case Next14Days = 'next14Days';
    case Next30Days = 'next30Days';
    case Next3Months = 'next3Months';
    case Next6Months = 'next6Months';
    case AllTime = 'allTime';
    case Custom = 'custom';

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    public function dates(?Carbon $start = null): array
    {
        return match ($this) {
            self::Today => [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()],
            self::Yesterday => [Carbon::now()->subDay()->startOfDay(), Carbon::now()->subDay()->endOfDay()],
            self::ThisWeek => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            self::LastWeek => [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()],
            self::Last7Days => [Carbon::now()->subDays(7)->addDay()->startOfDay(), Carbon::now()->endOfDay()],
            self::ThisMonth => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            self::LastMonth => [
                Carbon::now()->startOfMonth()->subMonth(),
                Carbon::now()->startOfMonth()->subMonth()->endOfMonth(),
            ],
            self::ThisQuarter => [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()],
            self::LastQuarter => [Carbon::now()->subQuarter()->startOfQuarter(), Carbon::now()->subQuarter()->endOfQuarter()],
            self::ThisYear => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            self::LastYear => [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()],
            self::Last14Days => [Carbon::now()->subDays(14)->addDay()->startOfDay(), Carbon::now()->endOfDay()],
            self::Last30Days => [Carbon::now()->subDays(30)->addDay()->startOfDay(), Carbon::now()->endOfDay()],
            self::Last3Months => [Carbon::now()->subMonths(3)->addDay()->startOfDay(), Carbon::now()->endOfDay()],
            self::Last6Months => [Carbon::now()->subMonths(6)->addDay()->startOfDay(), Carbon::now()->endOfDay()],
            self::YearToDate => [Carbon::now()->startOfYear(), Carbon::now()->endOfDay()],
            self::Tomorrow => [Carbon::now()->addDay()->startOfDay(), Carbon::now()->addDay()->endOfDay()],
            self::NextWeek => [Carbon::now()->addWeek()->startOfWeek(), Carbon::now()->addWeek()->endOfWeek()],
            self::Next7Days => [Carbon::now()->startOfDay(), Carbon::now()->addDays(6)->endOfDay()],
            self::NextMonth => [
                Carbon::now()->endOfMonth()->addDay()->startOfDay(),
                Carbon::now()->endOfMonth()->addDay()->endOfMonth()->endOfDay(),
            ],
            self::NextQuarter => [Carbon::now()->addQuarter()->startOfQuarter(), Carbon::now()->addQuarter()->endOfQuarter()],
            self::NextYear => [Carbon::now()->addYear()->startOfYear(), Carbon::now()->addYear()->endOfYear()],
            self::Next14Days => [Carbon::now()->startOfDay(), Carbon::now()->addDays(13)->endOfDay()],
            self::Next30Days => [Carbon::now()->startOfDay(), Carbon::now()->addDays(29)->endOfDay()],
            self::Next3Months => [Carbon::now()->startOfDay(), Carbon::now()->addMonths(3)->subDay()->endOfDay()],
            self::Next6Months => [Carbon::now()->startOfDay(), Carbon::now()->addMonths(6)->subDay()->endOfDay()],
            self::AllTime => [$start ?? Carbon::now()->startOfDay(), Carbon::now()->endOfDay()],
            self::Custom => [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()],
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Today => __('Today'),
            self::Yesterday => __('Yesterday'),
            self::ThisWeek => __('This Week'),
            self::LastWeek => __('Last Week'),
            self::Last7Days => __('Last 7 Days'),
            self::ThisMonth => __('This Month'),
            self::LastMonth => __('Last Month'),
            self::ThisQuarter => __('This Quarter'),
            self::LastQuarter => __('Last Quarter'),
            self::ThisYear => __('This Year'),
            self::LastYear => __('Last Year'),
            self::Last14Days => __('Last 14 Days'),
            self::Last30Days => __('Last 30 Days'),
            self::Last3Months => __('Last 3 Months'),
            self::Last6Months => __('Last 6 Months'),
            self::YearToDate => __('Year to Date'),
            self::Tomorrow => __('Tomorrow'),
            self::NextWeek => __('Next Week'),
            self::Next7Days => __('Next 7 Days'),
            self::NextMonth => __('Next Month'),
            self::NextQuarter => __('Next Quarter'),
            self::NextYear => __('Next Year'),
            self::Next14Days => __('Next 14 Days'),
            self::Next30Days => __('Next 30 Days'),
            self::Next3Months => __('Next 3 Months'),
            self::Next6Months => __('Next 6 Months'),
            self::AllTime => __('All Time'),
            self::Custom => __('Custom'),
        };
    }

    /**
     * @return list<array{key: string, label: string, start: string, end: string}>
     */
    public static function metadataForKeys(string $keys, ?Carbon $allTimeStart = null): array
    {
        $items = [];

        foreach (preg_split('/\s+/', trim($keys)) ?: [] as $key) {
            if ($key === '') {
                continue;
            }

            $preset = self::tryFrom($key);

            if ($preset === null || $preset === self::Custom) {
                continue;
            }

            if ($preset === self::AllTime && $allTimeStart === null) {
                continue;
            }

            [$start, $end] = $preset->dates($allTimeStart);

            $items[] = [
                'key' => $preset->value,
                'label' => $preset->label(),
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
            ];
        }

        return $items;
    }
}
