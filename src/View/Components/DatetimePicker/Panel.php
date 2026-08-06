<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\DatetimePicker;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Panel extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.datetime-picker.panel';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'panelLabel' => __('Select date and time'),
            'panelId' => $this->attributes->get('panel-id') ?? std_ancestor_attribute('panelId'),
        ];
    }
}
