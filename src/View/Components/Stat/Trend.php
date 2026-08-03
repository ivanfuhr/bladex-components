<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Stat;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Trend extends StencilComponent
{
    public function __construct(
        public mixed $direction = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.stat.trend';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'directionClasses' => match ($this->direction) {
                'up' => 'text-emerald-700 dark:text-emerald-400',
                'down' => 'text-red-700 dark:text-red-400',
                'neutral' => 'text-zinc-600 dark:text-zinc-300',
                default => 'text-zinc-600 dark:text-zinc-300',
            },
        ];
    }
}
