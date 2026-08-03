<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Sidebar extends StencilComponent
{
    public function __construct(
        public mixed $side = 'left',
        public mixed $variant = 'sidebar',
        public mixed $collapsible = 'offcanvas',
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.sidebar.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $resolvedSide = in_array($this->side, ['left', 'right'], true) ? $this->side : 'left';
        $resolvedVariant = in_array($this->variant, ['sidebar', 'floating', 'inset'], true) ? $this->variant : 'sidebar';
        $resolvedCollapsible = in_array($this->collapsible, ['offcanvas', 'icon', 'none'], true) ? $this->collapsible : 'offcanvas';

        return [
            'resolvedSide' => $resolvedSide,
            'resolvedVariant' => $resolvedVariant,
            'resolvedCollapsible' => $resolvedCollapsible,
            'isNonCollapsible' => $resolvedCollapsible === 'none',
            'isFloatingOrInset' => $resolvedVariant === 'floating' || $resolvedVariant === 'inset',
            'label' => $this->attributes->get('aria-label', 'Sidebar'),
        ];
    }
}
