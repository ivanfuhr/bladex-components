<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Main extends StencilComponent
{
    public function __construct(
        public bool $container = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.main.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'classes' => [
                'app-main',
                // Uniform inset padding under the shell header — avoid p-4 pt-0 (uneven).
                'flex min-h-0 flex-1 flex-col gap-4 overflow-y-auto p-4',
                $this->container ? 'mx-auto w-full max-w-7xl' : '',
            ],
        ];
    }
}
