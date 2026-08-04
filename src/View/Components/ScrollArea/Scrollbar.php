<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\ScrollArea;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Scrollbar extends StencilComponent
{
    public function __construct(
        public string $orientation = 'vertical',
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.scroll-area.scrollbar';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $orientation = $this->orientation === 'horizontal' ? 'horizontal' : 'vertical';
        $isVertical = $orientation === 'vertical';

        $scrollbarAttributes = $this->attributes
            ->class([
                'scroll-area__scrollbar',
                'flex',
                'touch-none',
                'select-none',
                'p-0.5',
                'transition-opacity',
                'duration-150',
                'ease-out',
                'motion-reduce:transition-none',
                'data-[state=hidden]:pointer-events-none',
                'data-[state=hidden]:opacity-0',
                'data-[state=visible]:opacity-100',
                $isVertical ? 'h-full w-2.5' : 'h-2.5 w-full flex-col',
                $isVertical
                    ? 'absolute top-0 right-0 bottom-0'
                    : 'absolute right-0 bottom-0 left-0',
            ])
            ->merge([
                'data-scroll-area-scrollbar' => true,
                'data-orientation' => $orientation,
                'data-state' => 'hidden',
                'aria-hidden' => 'true',
            ]);

        return [
            'orientation' => $orientation,
            'scrollbarAttributes' => $scrollbarAttributes,
        ];
    }
}
