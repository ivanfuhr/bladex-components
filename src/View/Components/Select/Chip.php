<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Select;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Chip extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.select.chip';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $size = $this->attributes->get('size') ?? std_ancestor_attribute('size');

        $chipSizeClasses = $size === 'sm'
            ? 'text-xs px-1.5 py-0'
            : 'text-xs px-2 py-0.5';

        $chipClasses = collect([
            'select__chip',
            'inline-flex max-w-full items-center gap-1 rounded-md border border-zinc-200 bg-zinc-50 font-medium text-zinc-700',
            'dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200',
            $chipSizeClasses,
        ])->implode(' ');

        return [
            'attributes' => $this->attributes->except('size'),
            'chipClasses' => $chipClasses,
        ];
    }
}
