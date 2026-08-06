<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Sidebar;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Provider extends StdComponent
{
    public function __construct(
        public bool $defaultOpen = true,
        public mixed $storageKey = 'std-sidebar-state',
        public mixed $width = '16rem',
        public mixed $widthIcon = '3.5rem',
        public mixed $widthMobile = '18rem',
        public mixed $headerHeight = '4rem',
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.sidebar.provider';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'isDefaultOpen' => $this->defaultOpen,
            'style' => '--std-sidebar-width: '.e($this->width).'; --std-sidebar-width-icon: '.e($this->widthIcon).'; --std-sidebar-width-mobile: '.e($this->widthMobile).'; --std-header-height: '.e($this->headerHeight).';',
        ];
    }
}
