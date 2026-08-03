<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class DatetimePicker extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = null,
        public mixed $placeholder = null,
        public bool $invalid = false,
        public bool $disabled = false,
        public bool $clearable = false,
        public mixed $size = null,
        public mixed $timezone = null,
        public mixed $locale = null,
        public bool $withSeconds = false,
        public int $timeStep = 30,
        public bool $withToday = false,
        public bool $shortcut = true,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.datetime-picker.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $invalid = $this->invalid || $fieldInvalid;
        $resolvedTimezone = stencil_resolve_timezone($this->timezone);
        $resolvedLocale = $this->locale ?? app()->getLocale();
        $resolvedValue = stencil_normalize_datetime_value($this->value, $resolvedTimezone);
        $resolvedPlaceholder = $this->placeholder ?? __('Select date and time');

        $datePart = $resolvedValue ? explode('T', $resolvedValue)[0] : '';

        return [
            'invalid' => $invalid,
            'resolvedTimezone' => $resolvedTimezone,
            'resolvedLocale' => $resolvedLocale,
            'resolvedValue' => $resolvedValue,
            'resolvedPlaceholder' => $resolvedPlaceholder,
            'datePart' => $datePart,
        ];
    }
}
