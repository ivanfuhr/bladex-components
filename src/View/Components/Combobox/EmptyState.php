<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Combobox;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class EmptyState extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.combobox.empty';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $emptyClasses = collect([
            'combobox__empty',
            'px-2 py-1.5 text-center text-sm text-zinc-500 dark:text-zinc-400',
        ])->implode(' ');

        return [
            'emptyClasses' => $emptyClasses,
        ];
    }
}
