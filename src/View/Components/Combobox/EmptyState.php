<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Combobox;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class EmptyState extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.combobox.empty';
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
