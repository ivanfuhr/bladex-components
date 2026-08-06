<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Command;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class EmptyState extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.command.empty';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'emptyClasses' => collect([
                'command__empty',
                'py-6 text-center text-sm text-zinc-500 dark:text-zinc-400',
            ])->implode(' '),
        ];
    }
}
