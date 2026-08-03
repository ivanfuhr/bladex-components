<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Stepper;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Indicator extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.stepper.indicator';
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
