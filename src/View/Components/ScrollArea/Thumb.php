<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\ScrollArea;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Thumb extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.scroll-area.thumb';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $thumbAttributes = $this->attributes
            ->class([
                'scroll-area__thumb',
                'relative',
                'rounded-full',
                'bg-zinc-400/50',
                'transition-colors',
                'duration-150',
                'ease-out',
                'motion-reduce:transition-none',
                'before:absolute',
                'before:-inset-1',
                'before:content-[\'\']',
                'hover:bg-zinc-400/80',
                'active:bg-zinc-500',
                'dark:bg-zinc-500/50',
                'dark:hover:bg-zinc-400/70',
                'dark:active:bg-zinc-400',
            ])
            ->merge([
                'data-scroll-area-thumb' => true,
                'data-state' => 'hidden',
            ]);

        return [
            'thumbAttributes' => $thumbAttributes,
        ];
    }
}
