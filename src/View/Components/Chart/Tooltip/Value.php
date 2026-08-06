<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Chart\Tooltip;

use Illuminate\Support\Js;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Value extends StdComponent
{
    public function __construct(
        public mixed $label = null,
        public mixed $field = null,
        public mixed $format = null,
        public mixed $prefix = null,
        public mixed $suffix = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.chart.tooltip.value';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'encodedFormat' => is_array($this->format) ? Js::encode($this->format) : $this->format,
        ];
    }
}
