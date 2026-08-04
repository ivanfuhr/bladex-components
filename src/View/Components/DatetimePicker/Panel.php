<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\DatetimePicker;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Panel extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.datetime-picker.panel';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'panelLabel' => __('Select date and time'),
        ];
    }
}
