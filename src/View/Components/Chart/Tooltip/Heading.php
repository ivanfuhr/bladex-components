<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Chart\Tooltip;

use Illuminate\Support\Js;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Heading extends StdComponent
{
    public function __construct(
        public mixed $field = 'date',
        public mixed $format = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.chart.tooltip.heading';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'encodedFormat' => is_array($this->format) ? Js::encode($this->format) : $this->format,
        ];
    }
}
