<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Tooltip;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Content extends StencilComponent
{
    public function __construct(
        public mixed $side = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.tooltip.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'resolvedSide' => $this->side ?? $this->aware('side', 'top'),
        ];
    }
}
