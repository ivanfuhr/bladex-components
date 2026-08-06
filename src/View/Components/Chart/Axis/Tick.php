<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Chart\Axis;

use Illuminate\Support\Js;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Tick extends StdComponent
{
    public function __construct(
        public mixed $format = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.chart.axis.tick';
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
