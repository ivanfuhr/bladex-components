<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Separator extends StencilComponent
{
    public function __construct(
        public mixed $orientation = 'horizontal',
        public bool $decorative = true,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.separator.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'isVertical' => $this->orientation === 'vertical',
        ];
    }
}
