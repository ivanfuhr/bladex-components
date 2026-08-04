<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\DatetimePicker;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class TimeList extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.datetime-picker.time-list';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'timeListId' => $this->attributes->get('time-list-id') ?? stencil_ancestor_attribute('timeListId'),
            'timeListLabel' => stencil_ancestor_attribute('timeListLabel', __('Select time')),
        ];
    }
}
