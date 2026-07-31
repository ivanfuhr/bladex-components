@props([
    'name' => null,
    'value' => null,
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'range' => false,
    'invalid' => false,
    'disabled' => false,
    'size' => null,
    'sliderId' => null,
    'shortcut' => true,
])

@aware([
    'fieldInvalid' => false,
    'controlId' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;

    $invalid = $invalid || $fieldInvalid;

    $formControl = app(FormControlClassMap::class);

    $min = is_numeric($min) ? (float) $min : 0.0;
    $max = is_numeric($max) ? (float) $max : 100.0;

    if ($max < $min) {
        [$min, $max] = [$max, $min];
    }

    $step = is_numeric($step) && (float) $step > 0 ? (float) $step : 1.0;

    $isRange = $range === true
        || (is_array($value) && count($value) >= 2);

    $normalize = static function (float $number) use ($min, $max, $step): float {
        $clamped = max($min, min($max, $number));

        if ($step <= 0) {
            return $clamped;
        }

        $steps = round(($clamped - $min) / $step);

        return max($min, min($max, $min + ($steps * $step)));
    };

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

    $sliderId = filled($sliderId)
        ? $sliderId
        : (filled($name) ? $name : 'slider-'.str_replace('.', '', uniqid('', true)));
    $controlId = filled($controlId) ? $controlId : $sliderId;

    $formatValue = static function (float $number): string {
        if (floor($number) == $number) {
            return (string) (int) $number;
        }

        return rtrim(rtrim(number_format($number, 6, '.', ''), '0'), '.');
    };

    $formattedValues = array_map($formatValue, $values);

    $rootAttributes = $attributes
        ->except(['shortcut', 'range', 'value', 'name', 'min', 'max', 'step'])
        ->class([
            $formControl->sliderRootClasses($size),
            'w-full' => ! filled($attributes->get('class')),
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

    if ($disabled) {
        $rootAttributes = $rootAttributes->merge(['data-disabled' => 'true']);
    }

    if ($invalid) {
        $rootAttributes = $rootAttributes->merge(['data-invalid' => 'true']);
    }
@endphp

<div {{ $rootAttributes }}>
    @foreach ($formattedValues as $index => $formattedValue)
        @if (filled($name))
            @php
                $inputName = $isRange ? $name.'['.$index.']' : $name;
            @endphp
            <input
                type="hidden"
                name="{{ $inputName }}"
                value="{{ $formattedValue }}"
                data-slider-hidden-input
                data-index="{{ $index }}"
            />
        @else
            <input
                type="hidden"
                value="{{ $formattedValue }}"
                data-slider-hidden-input
                data-index="{{ $index }}"
            />
        @endif
    @endforeach

    @if ($shortcut)
        <x-stencil::slider.track>
            <x-stencil::slider.range />
        </x-stencil::slider.track>
        @foreach ($values as $index => $thumbValue)
            <x-stencil::slider.thumb :index="$index" :value="$thumbValue" :range="$isRange" />
        @endforeach
    @else
        {{ $slot }}
    @endif
</div>
