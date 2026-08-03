<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Chart\Tooltip;

use Illuminate\Support\Js;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Heading extends StencilComponent
{
    public function __construct(
        public mixed $field = 'date',
        public mixed $format = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.chart.tooltip.heading';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'encodedFormat' => is_array($this->format) ? Js::encode($this->format) : $this->format,
        ];
    }
}
