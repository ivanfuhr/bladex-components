<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Command;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class EmptyState extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.command.empty';
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
