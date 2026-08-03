<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Chart\Summary;

use Illuminate\Support\Js;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Value extends StencilComponent
{
    public function __construct(
        public mixed $field = null,
        public mixed $format = null,
        public mixed $fallback = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.chart.summary.value';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'encodedFormat' => is_array($this->format) ? Js::encode($this->format) : $this->format,
        ];
    }
}
