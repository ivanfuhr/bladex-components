<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\ColorPicker;

use Illuminate\Support\Facades\View;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Hue extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.color-picker.hue';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'disabled' => (bool) View::getConsumableComponentData('disabled', false),
        ];
    }
}
