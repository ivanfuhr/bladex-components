<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\DatePicker;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Selected extends StencilComponent
{
    public function __construct(
        public mixed $placeholder = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.date-picker.selected';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'resolvedPlaceholder' => filled($this->placeholder) ? $this->placeholder : null,
        ];
    }
}
