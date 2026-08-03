<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Skeleton extends StencilComponent
{
    public function __construct(
        public mixed $rounded = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.skeleton.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'radius' => match ($this->rounded) {
                'full', 'circle' => 'rounded-full',
                'none' => 'rounded-none',
                'sm' => 'rounded-sm',
                'lg' => 'rounded-lg',
                default => 'rounded-md',
            },
        ];
    }
}
