<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\TimePicker;

use Illuminate\Support\Facades\View;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Input extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.time-picker.input.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'placeholder' => View::getConsumableComponentData('placeholder', null),
            'invalid' => View::getConsumableComponentData('invalid', false),
            'disabled' => View::getConsumableComponentData('disabled', false),
            'clearable' => View::getConsumableComponentData('clearable', false),
            'size' => View::getConsumableComponentData('size', null),
            'listboxId' => $this->attributes->get('listbox-id') ?? View::getConsumableComponentData('listboxId'),
        ];
    }
}
