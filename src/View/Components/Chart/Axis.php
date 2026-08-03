<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Chart;

use Illuminate\Support\Js;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Axis extends StencilComponent
{
    public function __construct(
        public mixed $axis = 'x',
        public mixed $field = null,
        public mixed $format = null,
        public mixed $position = null,
        public mixed $tickValues = null,
        public mixed $tickPrefix = null,
        public mixed $tickSuffix = null,
        public mixed $tickCount = null,
        public mixed $tickStart = null,
        public mixed $tickEnd = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.chart.axis.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'encodedFormat' => is_array($this->format) ? Js::encode($this->format) : $this->format,
            'resolvedField' => $this->field ?? ($this->axis === 'x' ? 'date' : 'value'),
            'encodedTickValues' => is_array($this->tickValues) ? json_encode($this->tickValues) : $this->tickValues,
        ];
    }
}
