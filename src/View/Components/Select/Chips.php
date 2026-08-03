<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Select;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Chips extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.select.chips';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $placeholder = $this->attributes->get('placeholder') ?? stencil_ancestor_attribute('placeholder');
        $resolvedPlaceholder = filled($placeholder) ? $placeholder : null;
        $size = $this->attributes->get('size') ?? stencil_ancestor_attribute('size');

        $chipSizeClasses = $size === 'sm'
            ? 'text-xs px-1.5 py-0'
            : 'text-xs px-2 py-0.5';

        $chipClasses = collect([
            'select__chip',
            'inline-flex max-w-full items-center gap-1 rounded-md border border-zinc-200 bg-zinc-50 font-medium text-zinc-700',
            'dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200',
            $chipSizeClasses,
        ])->implode(' ');

        $chipLabelClasses = 'min-w-0 truncate';
        $chipRemoveClasses = collect([
            'select__chip-remove',
            'inline-flex shrink-0 items-center justify-center rounded-sm text-zinc-500 hover:text-zinc-900',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
            'dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20',
            $size === 'sm' ? 'size-3.5' : 'size-4',
        ])->implode(' ');

        return [
            'attributes' => $this->attributes->except(['placeholder', 'size']),
            'resolvedPlaceholder' => $resolvedPlaceholder,
            'size' => $size,
            'chipClasses' => $chipClasses,
            'chipLabelClasses' => $chipLabelClasses,
            'chipRemoveClasses' => $chipRemoveClasses,
        ];
    }
}
