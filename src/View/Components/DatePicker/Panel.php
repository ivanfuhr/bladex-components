<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\DatePicker;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Panel extends StdComponent
{
    public function __construct(
        public bool $range = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.date-picker.panel';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'panelLabel' => $this->range
                ? __('Select a date range')
                : __('Select a date'),
            'panelId' => $this->attributes->get('panel-id') ?? std_ancestor_attribute('panelId'),
        ];
    }
}
