<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\TimePicker;

use Illuminate\Support\Facades\View;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Input extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.time-picker.input.index';
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
