<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Progress extends StencilComponent
{
    public function __construct(
        public int $value = 0,
        public int $max = 100,
        public bool $indeterminate = false,
        public mixed $size = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.progress.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        $max = max(1, (float) $this->max);
        $value = max(0, min($max, (float) $this->value));

        return [
            'resolvedMax' => $max,
            'resolvedValue' => $value,
            'percent' => $this->indeterminate ? null : round(($value / $max) * 100, 2),
            'height' => match ($this->size) {
                'sm' => 'h-1.5',
                'lg' => 'h-3',
                default => 'h-2',
            },
        ];
    }
}
