<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Empty;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Title extends StencilComponent
{
    public function __construct(
        public int $level = 3,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.empty.title';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'resolvedLevel' => max(1, min(6, $this->level)),
        ];
    }
}
