@aware([
    'value' => null,
    'min' => 0,
    'max' => 100,
    'range' => false,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;

    $formControl = app(FormControlClassMap::class);

    $min = is_numeric($min) ? (float) $min : 0.0;
    $max = is_numeric($max) ? (float) $max : 100.0;

    if ($max < $min) {
        [$min, $max] = [$max, $min];
    }

    $span = $max - $min;

    $isRange = $range === true
        || (is_array($value) && count($value) >= 2);

    $clamp = static function (float $number) use ($min, $max): float {
        return max($min, min($max, $number));
    };

    if (is_array($value)) {
        $values = array_map(
            static fn ($item): float => $clamp((float) $item),
            array_values(array_slice($value, 0, $isRange ? 2 : 1)),
        );
    } elseif (filled($value) || $value === 0 || $value === 0.0 || $value === '0') {
        $values = [$clamp((float) $value)];
    } else {
        $values = $isRange ? [$min, $max] : [$min];
    }

    if ($isRange) {
        $low = (float) ($values[0] ?? $min);
        $high = (float) ($values[1] ?? $max);

        if ($low > $high) {
            [$low, $high] = [$high, $low];
        }

        $start = $span > 0 ? (($low - $min) / $span) * 100 : 0;
        $end = $span > 0 ? (($high - $min) / $span) * 100 : 100;
    } else {
        $current = (float) ($values[0] ?? $min);
        $start = 0;
        $end = $span > 0 ? (($current - $min) / $span) * 100 : 0;
    }

    $start = max(0, min(100, $start));
    $end = max(0, min(100, $end));

    $rangeClasses = $formControl->sliderRangeClasses();
@endphp

<div
    {{
        $attributes->class($rangeClasses)->merge([
            'data-slider-range' => true,
            'style' => 'left: '.$start.'%; width: '.max(0, $end - $start).'%;',
        ])
    }}
></div>
