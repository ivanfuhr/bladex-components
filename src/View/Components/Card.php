<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Card extends StdComponent
{
    public function __construct(
        public mixed $size = 'default',
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.card.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'padding' => $this->size === 'sm' ? 'p-4' : 'p-6',
        ];
    }
}
