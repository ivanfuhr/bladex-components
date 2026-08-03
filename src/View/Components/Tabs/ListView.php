<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Tabs;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class ListView extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.tabs.list';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $orientation = $this->aware('orientation', 'horizontal');
        $variant = $this->aware('variant', 'default');

        $listClasses = match ($variant) {
            'segmented' => 'inline-flex items-center gap-1 rounded-lg bg-zinc-100 p-1 dark:bg-zinc-800',
            'pills' => 'inline-flex items-center gap-2',
            'line' => 'inline-flex items-center gap-4 border-b border-zinc-200 dark:border-zinc-800',
            default => 'inline-flex items-center gap-1 rounded-lg bg-zinc-100 p-1 dark:bg-zinc-800',
        };

        return [
            'orientation' => $orientation,
            'listClasses' => $listClasses,
        ];
    }
}
