<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Chart\Summary;

use Illuminate\Support\Js;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Value extends StdComponent
{
    public function __construct(
        public mixed $field = null,
        public mixed $format = null,
        public mixed $fallback = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.chart.summary.value';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'encodedFormat' => is_array($this->format) ? Js::encode($this->format) : $this->format,
        ];
    }
}
