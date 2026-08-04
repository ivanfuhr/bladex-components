<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\ScrollArea;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Corner extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.scroll-area.corner';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $cornerAttributes = $this->attributes
            ->class([
                'scroll-area__corner',
                'absolute',
                'right-0',
                'bottom-0',
                'size-2.5',
                'bg-transparent',
                'transition-opacity',
                'duration-150',
                'ease-out',
                'motion-reduce:transition-none',
                'data-[state=hidden]:opacity-0',
                'data-[state=visible]:opacity-100',
            ])
            ->merge([
                'data-scroll-area-corner' => true,
                'data-state' => 'hidden',
                'aria-hidden' => 'true',
            ]);

        return [
            'cornerAttributes' => $cornerAttributes,
        ];
    }
}
