<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Slider;

use Illuminate\Support\Facades\View;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Thumb extends StencilComponent
{
    public function __construct(
        public int $index = 0,
        public mixed $value = null,
        public bool $range = false,
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $size = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.slider.thumb';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $size = $this->size;
        $disabled = $this->disabled;
        $fieldInvalid = (bool) View::getConsumableComponentData('fieldInvalid', false);
        $name = View::getConsumableComponentData('name', null);

        $isInvalid = $this->invalid || $fieldInvalid || stencil_field_has_errors($name);
        $index = max(0, $this->index);

        $min = (float) View::getConsumableComponentData('min', 0);
        $max = (float) View::getConsumableComponentData('max', 100);
        $rawStep = View::getConsumableComponentData('step', 1);
        $step = is_numeric($rawStep) && (float) $rawStep > 0 ? (float) $rawStep : 1.0;
        $span = $max - $min;

        $isRange = $this->range === true;

        $formatValue = static function (float $number): string {
            if (floor($number) == $number) {
                return (string) (int) $number;
            }

            return rtrim(rtrim(number_format($number, 6, '.', ''), '0'), '.');
        };

        $value = $this->value;

        if (filled($value) || $value === 0 || $value === 0.0 || $value === '0') {
            $thumbValue = (float) $value;
        } else {
            $thumbValue = $index === 0 ? $min : $max;
        }

        $thumbValue = max($min, min($max, $thumbValue));

        $percent = $span > 0 ? (($thumbValue - $min) / $span) * 100 : 0;
        $percent = max(0, min(100, $percent));

        $sliderId = View::getConsumableComponentData('sliderId', null);
        $resolvedSliderId = filled($sliderId) ? $sliderId : (filled($name) ? $name : null);
        $controlId = View::getConsumableComponentData('controlId', null);
        $resolvedControlId = filled($controlId) ? $controlId : $resolvedSliderId;

        $thumbId = filled($resolvedControlId)
            ? $resolvedControlId.($index === 0 ? '' : '-'.$index)
            : null;

        $ariaLabel = $isRange
            ? ($index === 0
                ? __('Minimum')
                : __('Maximum'))
            : __('Value');

        $thumbClasses = stencil_slider_thumb_classes($size);

        $thumbAttributes = $this->attributes
            ->class($thumbClasses)
            ->merge([
                'role' => 'slider',
                'tabindex' => $disabled ? '-1' : '0',
                'aria-orientation' => 'horizontal',
                'aria-valuemin' => $formatValue($min),
                'aria-valuemax' => $formatValue($max),
                'aria-valuenow' => $formatValue($thumbValue),
                'aria-valuetext' => $formatValue($thumbValue),
                'aria-label' => $ariaLabel,
                'data-slider-thumb' => true,
                'data-index' => (string) $index,
                'style' => 'left: '.$percent.'%;',
            ]);

        if ($disabled) {
            $thumbAttributes = $thumbAttributes->merge([
                'disabled' => true,
                'aria-disabled' => 'true',
                'tabindex' => '-1',
            ]);
        }

        $thumbAttributes = stencil_apply_interaction($thumbAttributes, nativeDisabled: false);

        if ($disabled) {
            $thumbAttributes = $thumbAttributes
                ->except('disabled')
                ->merge([
                    'aria-disabled' => 'true',
                    'tabindex' => '-1',
                ]);
        }

        if ($isInvalid) {
            $thumbAttributes = $thumbAttributes->merge(['aria-invalid' => 'true']);
        }

        if (filled($thumbId)) {
            $thumbAttributes = $thumbAttributes->merge(['id' => $thumbId]);
        }

        return [
            'thumbAttributes' => $thumbAttributes,
        ];
    }
}
