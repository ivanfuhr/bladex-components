<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Calendar extends StdComponent
{
    public function __construct(
        public mixed $mode = 'single',
        public mixed $months = null,
        public mixed $value = null,
        public mixed $name = null,
        public mixed $min = null,
        public mixed $max = null,
        public mixed $unavailable = null,
        public mixed $startDay = null,
        public mixed $locale = null,
        public mixed $timezone = null,
        public bool $weekNumbers = false,
        public bool $selectableHeader = false,
        public bool $withToday = false,
        public bool $fixedWeeks = false,
        public mixed $openTo = null,
        public bool $forceOpenTo = false,
        public mixed $size = 'default',
        public mixed $minRange = null,
        public mixed $maxRange = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.calendar.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $range = $this->mode === 'range';
        $monthCount = (int) ($this->months ?? ($range ? 2 : 1));
        $resolvedTimezone = std_resolve_timezone($this->timezone);
        $resolvedLocale = $this->locale ?? app()->getLocale();
        $resolvedValue = std_normalize_date_value($this->value, $this->mode);

        $unavailable = $this->unavailable;

        if (is_array($unavailable)) {
            $unavailable = collect($unavailable)->implode(',');
        }

        $sizeClasses = match ($this->size) {
            'sm' => 'size-9 text-sm',
            'lg' => 'size-11 text-sm',
            'xl' => 'size-12 text-sm',
            '2xl' => 'size-12 sm:size-14 text-sm',
            default => 'size-10 text-sm',
        };

        return [
            'monthCount' => $monthCount,
            'resolvedTimezone' => $resolvedTimezone,
            'resolvedLocale' => $resolvedLocale,
            'resolvedValue' => $resolvedValue,
            'unavailable' => $unavailable,
            'sizeClasses' => $sizeClasses,
        ];
    }
}
