<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Stepper;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Indicator extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.stepper.indicator';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $value = $this->aware('value');
        $step = $this->aware('step');
        $completed = $this->aware('completed');

        return [
            'isCompleted' => $completed === true,
            'label' => filled($step) ? (string) $step : (filled($value) ? (string) $value : ''),
        ];
    }
}
