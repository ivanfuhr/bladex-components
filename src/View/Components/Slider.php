<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\Support\Str;

final class Slider extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = null,
        public int|float $min = 0,
        public int|float $max = 100,
        public int|float $step = 1,
        public bool $range = false,
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $size = null,
        public mixed $sliderId = null,
        public bool $shortcut = true,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.slider.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $controlId = $data['controlId'] ?? null;

        $invalid = $this->invalid || $fieldInvalid || stencil_field_has_errors($this->name);
        $min = (float) $this->min;
        $max = (float) $this->max;

        if ($max < $min) {
            [$min, $max] = [$max, $min];
        }

        $step = $this->step > 0 ? (float) $this->step : 1.0;

        $isRange = $this->range === true
            || (is_array($this->value) && count($this->value) >= 2);

        $normalize = static function (float $number) use ($min, $max, $step): float {
            $clamped = max($min, min($max, $number));

            if ($step <= 0) {
                return $clamped;
            }

            $steps = round(($clamped - $min) / $step);

            return max($min, min($max, $min + ($steps * $step)));
        };

        $value = $this->value;

        if (is_array($value)) {
            $rawValues = array_values(array_slice($value, 0, $isRange ? 2 : 1));
        } elseif (filled($value) || $value === 0 || $value === 0.0 || $value === '0') {
            $rawValues = [(float) $value];
        } else {
            $rawValues = $isRange ? [$min, $max] : [$min];
        }

        if ($isRange) {
            $low = $normalize((float) ($rawValues[0] ?? $min));
            $high = $normalize((float) ($rawValues[1] ?? $max));

            if ($low > $high) {
                [$low, $high] = [$high, $low];
            }

            $values = [$low, $high];
        } else {
            $values = [$normalize((float) ($rawValues[0] ?? $min))];
        }

        $sliderId = filled($this->sliderId)
            ? $this->sliderId
            : (filled($this->name) ? $this->name : 'slider-'.Str::uuid()->toString());
        $controlId = filled($controlId) ? $controlId : $sliderId;

        $formatValue = static function (float $number): string {
            if (floor($number) == $number) {
                return (string) (int) $number;
            }

            return rtrim(rtrim(number_format($number, 6, '.', ''), '0'), '.');
        };

        $formattedValues = array_map($formatValue, $values);

        $rootAttributes = $this->attributes
            ->class([
                stencil_slider_root_classes($this->size),
                'w-full' => ! filled($this->attributes->get('class')),
            ])
            ->merge([
                'data-slider' => true,
                'data-slider-id' => $sliderId,
                'data-slider-min' => $formatValue($min),
                'data-slider-max' => $formatValue($max),
                'data-slider-step' => $formatValue($step),
                'data-slider-range' => $isRange ? 'true' : 'false',
                'role' => 'group',
            ]);

        if ($this->disabled) {
            $rootAttributes = $rootAttributes->merge(['data-disabled' => 'true']);
        }

        if ($invalid) {
            $rootAttributes = $rootAttributes->merge(['data-invalid' => 'true']);
        }

        return [
            'invalid' => $invalid,
            'isRange' => $isRange,
            'min' => $min,
            'max' => $max,
            'step' => $step,
            'sliderId' => $sliderId,
            'values' => $values,
            'formattedValues' => $formattedValues,
            'rootAttributes' => $rootAttributes,
        ];
    }
}
