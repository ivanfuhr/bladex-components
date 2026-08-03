<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\DatePicker;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Panel extends StencilComponent
{
    public function __construct(
        public bool $range = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.date-picker.panel';
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
        ];
    }
}
