<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Stepper;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Trigger extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.stepper.trigger';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        // Read purely from the ancestor item/stepper: declaring these as
        // constructor properties on this component would shadow the
        // ancestor's value (an own key always wins over an ancestor lookup).
        $value = $this->aware('value');
        $stepperId = $this->aware('stepperId');
        $defaultValue = $this->aware('defaultValue');
        $orientation = $this->aware('orientation', 'horizontal');
        $isDisabled = (bool) $this->aware('disabled', false);

        $isCurrent = filled($defaultValue) && filled($value) && (string) $value === (string) $defaultValue;

        $triggerId = $this->attributes->get('id')
            ?? (filled($stepperId) && filled($value) ? $stepperId.'-trigger-'.$value : null);
        $panelId = filled($stepperId) && filled($value) ? $stepperId.'-panel-'.$value : null;

        return [
            'value' => $value,
            'isVertical' => $orientation === 'vertical',
            'isDisabled' => $isDisabled,
            'isCurrent' => $isCurrent,
            'triggerId' => $triggerId,
            'panelId' => $panelId,
        ];
    }
}
