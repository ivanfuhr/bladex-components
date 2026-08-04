<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class ScrollArea extends StencilComponent
{
    public function __construct(
        public string $type = 'hover',
        public int $scrollHideDelay = 600,
        public bool $horizontal = false,
        public bool $shortcut = true,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.scroll-area.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $type = match ($this->type) {
            'always', 'scroll', 'auto', 'hover' => $this->type,
            default => 'hover',
        };

        $scrollHideDelay = max(0, $this->scrollHideDelay);

        $rootAttributes = $this->attributes
            ->class([
                'scroll-area',
                'relative',
                'overflow-hidden',
            ])
            ->merge([
                'data-scroll-area' => true,
                'data-scroll-area-type' => $type,
                'data-scroll-area-hide-delay' => (string) $scrollHideDelay,
            ]);

        return [
            'type' => $type,
            'scrollHideDelay' => $scrollHideDelay,
            'horizontal' => $this->horizontal,
            'shortcut' => $this->shortcut,
            'rootAttributes' => $rootAttributes,
        ];
    }
}
