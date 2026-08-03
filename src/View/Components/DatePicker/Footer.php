<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\DatePicker;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Footer extends StencilComponent
{
    public function __construct(
        public bool $range = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.date-picker.footer';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'confirmLabel' => $this->range
                ? __('Select range')
                : __('Select date'),
        ];
    }
}
