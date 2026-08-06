<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Skeleton extends StdComponent
{
    public function __construct(
        public mixed $rounded = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.skeleton.index';
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
