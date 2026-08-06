<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Stat;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Trend extends StdComponent
{
    public function __construct(
        public mixed $direction = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.stat.trend';
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
            'directionLabel' => match ((string) $this->direction) {
                'up' => 'Trending up',
                'down' => 'Trending down',
                'neutral' => 'No change',
                default => null,
            },
        ];
    }
}
