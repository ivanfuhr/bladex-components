<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

final class DatePicker extends StdComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = null,
        public mixed $mode = 'single',
        public mixed $type = 'button',
        public mixed $placeholder = null,
        public mixed $size = null,
        public bool $invalid = false,
        public bool $disabled = false,
        public bool $clearable = false,
        public mixed $locale = null,
        public mixed $timezone = null,
        public mixed $months = null,
        public mixed $min = null,
        public mixed $max = null,
        public mixed $unavailable = null,
        public mixed $startDay = null,
        public bool $weekNumbers = false,
        public bool $selectableHeader = false,
        public bool $withToday = false,
        public bool $fixedWeeks = false,
        public mixed $openTo = null,
        public bool $forceOpenTo = false,
        public bool $withConfirmation = false,
        public bool $withInputs = false,
        public bool $withPresets = false,
        public mixed $presets = null,
        public mixed $minRange = null,
        public mixed $maxRange = null,
        public bool $shortcut = true,
        public mixed $allTimeStart = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.date-picker.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $invalid = $this->invalid || $fieldInvalid;
        $range = $this->mode === 'range';
        $resolvedTimezone = std_resolve_timezone($this->timezone);
        $resolvedLocale = $this->locale ?? app()->getLocale();
        $resolvedValue = std_normalize_date_value($this->value, $this->mode);
        $monthCount = (int) ($this->months ?? ($range ? 2 : 1));

        $presetKeys = $this->withPresets
            ? ($this->presets ?? 'today yesterday thisWeek last7Days thisMonth yearToDate allTime custom')
            : null;

        $presetMeta = $presetKeys
            ? std_date_preset_metadata(
                $presetKeys,
                filled($this->allTimeStart) ? Carbon::parse($this->allTimeStart) : null,
            )
            : [];

        $pickerId = filled($this->name)
            ? (string) $this->name
            : 'date-picker-'.Str::uuid()->toString();
        $panelId = $pickerId.'-panel';

        return [
            'invalid' => $invalid,
            'range' => $range,
            'resolvedTimezone' => $resolvedTimezone,
            'resolvedLocale' => $resolvedLocale,
            'resolvedValue' => $resolvedValue,
            'monthCount' => $monthCount,
            'presetMeta' => $presetMeta,
            'pickerId' => $pickerId,
            'panelId' => $panelId,
        ];
    }
}
