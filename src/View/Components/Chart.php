<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\Support\Js;

final class Chart extends StencilComponent
{
    public function __construct(
        public mixed $value = null,
        public mixed $label = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.chart.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'encodedValue' => is_array($this->value) ? Js::encode($this->value) : $this->value,
        ];
    }
}
