<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Sidebar;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Provider extends StencilComponent
{
    public function __construct(
        public bool $defaultOpen = true,
        public mixed $storageKey = 'stencil-sidebar-state',
        public mixed $width = '16rem',
        public mixed $widthIcon = '3.5rem',
        public mixed $widthMobile = '18rem',
        public mixed $headerHeight = '4rem',
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.sidebar.provider';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'isDefaultOpen' => $this->defaultOpen,
            'style' => '--stencil-sidebar-width: '.e($this->width).'; --stencil-sidebar-width-icon: '.e($this->widthIcon).'; --stencil-sidebar-width-mobile: '.e($this->widthMobile).'; --stencil-header-height: '.e($this->headerHeight).';',
        ];
    }
}
