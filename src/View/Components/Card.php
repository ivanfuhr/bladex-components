<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Card extends StencilComponent
{
    public function __construct(
        public mixed $size = 'default',
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.card.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'padding' => $this->size === 'sm' ? 'p-4' : 'p-6',
        ];
    }
}
