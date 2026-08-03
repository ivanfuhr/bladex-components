<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Chart\Tooltip;

use Illuminate\Support\Js;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Value extends StencilComponent
{
    public function __construct(
        public mixed $label = null,
        public mixed $field = null,
        public mixed $format = null,
        public mixed $prefix = null,
        public mixed $suffix = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.chart.tooltip.value';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'encodedFormat' => is_array($this->format) ? Js::encode($this->format) : $this->format,
        ];
    }
}
