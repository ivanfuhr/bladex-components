<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Popover;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Content extends StencilComponent
{
    public function __construct(
        public bool $open = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.popover.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'align' => $this->aware('align', 'start'),
            'side' => $this->aware('side', 'bottom'),
        ];
    }
}
