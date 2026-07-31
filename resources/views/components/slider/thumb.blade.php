@aware([
    'size' => null,
    'invalid' => false,
    'fieldInvalid' => false,
    'disabled' => false,
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'range' => false,
    'sliderId' => null,
    'name' => null,
    'controlId' => null,
])

@props([
    'index' => 0,
    'value' => null,
    'range' => false,
    'invalid' => false,
    'disabled' => false,
    'size' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $isInvalid = $invalid || $fieldInvalid;
    $index = max(0, (int) $index);

    $min = is_numeric($min) ? (float) $min : 0.0;
    $max = is_numeric($max) ? (float) $max : 100.0;
    $step = is_numeric($step) && (float) $step > 0 ? (float) $step : 1.0;
    $span = $max - $min;

    $isRange = $range === true;

    $formatValue = static function (float $number): string {
        if (floor($number) == $number) {
            return (string) (int) $number;
        }

        return rtrim(rtrim(number_format($number, 6, '.', ''), '0'), '.');
    };

    if (filled($value) || $value === 0 || $value === 0.0 || $value === '0') {
        $thumbValue = (float) $value;
    } else {
        $thumbValue = $index === 0 ? $min : $max;
    }

    $thumbValue = max($min, min($max, $thumbValue));

    $percent = $span > 0 ? (($thumbValue - $min) / $span) * 100 : 0;
    $percent = max(0, min(100, $percent));

    $resolvedSliderId = filled($sliderId)
        ? $sliderId
        : (filled($name) ? $name : null);
    $resolvedControlId = filled($controlId) ? $controlId : $resolvedSliderId;

    $thumbId = filled($resolvedControlId)
        ? $resolvedControlId.($index === 0 ? '' : '-'.$index)
        : null;

    $ariaLabel = $isRange
        ? ($index === 0
            ? __('stencil::messages.slider_min')
            : __('stencil::messages.slider_max'))
        : __('stencil::messages.slider_value');

    $thumbClasses = $formControl->sliderThumbClasses($size);

    $thumbAttributes = $attributes
        ->except(['index', 'invalid', 'disabled', 'size', 'value', 'range'])
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

    $thumbAttributes = $interactionState->apply($thumbAttributes, ['nativeDisabled' => false]);

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
@endphp

<span {{ $thumbAttributes }}></span>
