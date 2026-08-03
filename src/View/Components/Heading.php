<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Heading extends StencilComponent
{
    public function __construct(
        public mixed $level = null,
        public mixed $variant = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.heading.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        $level = max(1, min(6, (int) ($this->level ?? stencil_default_heading_level())));

        return [
            'resolvedLevel' => $level,
            'classes' => stencil_heading_classes($level, $this->variant),
        ];
    }
}
