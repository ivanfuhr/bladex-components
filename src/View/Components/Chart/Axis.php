<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Chart;

use Illuminate\Support\Js;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Axis extends StdComponent
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

    protected function stdView(): string
    {
        return 'std-components::components.chart.axis.index';
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
