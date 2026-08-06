<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Separator extends StdComponent
{
    public function __construct(
        public mixed $orientation = 'horizontal',
        public bool $decorative = true,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.separator.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'isVertical' => $this->orientation === 'vertical',
        ];
    }
}
