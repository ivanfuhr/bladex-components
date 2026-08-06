<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\ColorPicker;

use Illuminate\Support\Facades\View;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Hue extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.color-picker.hue';
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
