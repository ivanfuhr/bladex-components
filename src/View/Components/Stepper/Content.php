<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Stepper;

use InvalidArgumentException;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Content extends StencilComponent
{
    public function __construct(
        public mixed $value = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.stepper.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $stepValue = $this->value ?? $this->attributes->get('value');
        $attributes = $this->attributes->except('value');

        if (! filled($stepValue)) {
            throw new InvalidArgumentException('The stepper content component requires a [value] attribute.');
        }

        $defaultValue = $this->aware('defaultValue');
        $stepperId = $this->aware('stepperId');
        $orientation = $this->aware('orientation', 'horizontal');

        $isSelected = filled($defaultValue) && (string) $stepValue === (string) $defaultValue;
        $panelId = $attributes->get('id')
            ?? (filled($stepperId) ? $stepperId.'-panel-'.$stepValue : null);
        $triggerId = filled($stepperId) ? $stepperId.'-trigger-'.$stepValue : null;

        return [
            'attributes' => $attributes,
            'stepValue' => $stepValue,
            'isSelected' => $isSelected,
            'panelId' => $panelId,
            'triggerId' => $triggerId,
            'isVertical' => $orientation === 'vertical',
        ];
    }
}
