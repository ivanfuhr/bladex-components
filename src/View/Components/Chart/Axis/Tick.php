<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Chart\Axis;

use Illuminate\Support\Js;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Tick extends StencilComponent
{
    public function __construct(
        public mixed $format = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.chart.axis.tick';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'axis' => $this->aware('axis', 'x'),
            'position' => $this->aware('position'),
            'encodedFormat' => is_array($this->format) ? Js::encode($this->format) : $this->format,
        ];
    }
}
