<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\ScrollArea;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Viewport extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.scroll-area.viewport';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $viewportAttributes = $this->attributes
            ->class([
                'scroll-area__viewport',
                'size-full',
                'rounded-[inherit]',
                'outline-none',
                'focus-visible:ring-2',
                'focus-visible:ring-zinc-950/10',
                'focus-visible:ring-offset-2',
                'focus-visible:ring-offset-white',
                'dark:focus-visible:ring-zinc-300/20',
                'dark:focus-visible:ring-offset-zinc-950',
            ])
            ->merge([
                'data-scroll-area-viewport' => true,
                'tabindex' => '0',
            ]);

        return [
            'viewportAttributes' => $viewportAttributes,
        ];
    }
}
