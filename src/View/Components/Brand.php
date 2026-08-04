<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Brand extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $logo = null,
        public mixed $logoDark = null,
        public mixed $alt = null,
        public mixed $href = '/',
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.brand.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $resolvedAlt = filled($this->alt)
            ? (string) $this->alt
            : (filled($this->name) ? '' : __('Home'));

        return [
            'resolvedLogoDark' => $this->logoDark ?? $this->attributes->get('logo:dark'),
            'resolvedAlt' => $resolvedAlt,
            'classes' => array_filter([
                'brand',
                'flex h-10 items-center me-4',
                filled($this->name) ? 'gap-2' : null,
            ]),
            'nameClasses' => 'truncate text-sm font-medium text-zinc-800 dark:text-zinc-100',
            'logoWrapperClasses' => 'flex h-6 min-w-6 shrink-0 items-center justify-center overflow-hidden rounded-sm',
            'imageClasses' => 'h-6',
        ];
    }
}
