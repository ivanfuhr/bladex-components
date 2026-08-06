<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\DatetimePicker;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class TimeList extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.datetime-picker.time-list';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'timeListId' => $this->attributes->get('time-list-id') ?? std_ancestor_attribute('timeListId'),
            'timeListLabel' => std_ancestor_attribute('timeListLabel', __('Select time')),
        ];
    }
}
