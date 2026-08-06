<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

use Illuminate\Support\Str;

final class TimePicker extends StdComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = null,
        public mixed $placeholder = null,
        public mixed $type = 'button',
        public bool $invalid = false,
        public bool $disabled = false,
        public bool $clearable = false,
        public mixed $size = null,
        public bool $withSeconds = false,
        public int $step = 30,
        public mixed $unavailable = null,
        public mixed $timezone = null,
        public mixed $locale = null,
        public bool $shortcut = true,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.time-picker.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $invalid = $this->invalid || $fieldInvalid;
        $resolvedTimezone = std_resolve_timezone($this->timezone);
        $resolvedLocale = $this->locale ?? app()->getLocale();
        $resolvedValue = std_normalize_time_value($this->value, $this->withSeconds);

        $unavailable = $this->unavailable;

        if (is_array($unavailable)) {
            $unavailable = collect($unavailable)->implode(',');
        }

        $pickerId = filled($this->name)
            ? (string) $this->name
            : 'time-picker-'.Str::uuid()->toString();
        $listboxId = $pickerId.'-listbox';

        return [
            'invalid' => $invalid,
            'resolvedTimezone' => $resolvedTimezone,
            'resolvedLocale' => $resolvedLocale,
            'resolvedValue' => $resolvedValue,
            'unavailable' => $unavailable,
            'pickerId' => $pickerId,
            'listboxId' => $listboxId,
            'listboxLabel' => __('Select time'),
        ];
    }
}
