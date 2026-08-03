<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Stepper;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Separator extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.stepper.separator';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'isVertical' => $this->aware('orientation', 'horizontal') === 'vertical',
        ];
    }
}
