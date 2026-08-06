<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Slider;

use Illuminate\Support\Facades\View;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Range extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.slider.range';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $value = View::getConsumableComponentData('value', null);
        $min = (float) View::getConsumableComponentData('min', 0);
        $max = (float) View::getConsumableComponentData('max', 100);
        $range = View::getConsumableComponentData('range', false);

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
                static fn (mixed $item): float => $clamp((float) $item),
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

        return [
            'rangeClasses' => std_slider_range_classes(),
            'rangeStart' => $start,
            'rangeEnd' => $end,
        ];
    }
}
