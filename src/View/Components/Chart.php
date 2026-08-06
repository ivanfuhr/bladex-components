<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

use Illuminate\Support\Js;

final class Chart extends StdComponent
{
    public function __construct(
        public mixed $value = null,
        public mixed $label = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.chart.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'encodedValue' => is_array($this->value) ? Js::encode($this->value) : $this->value,
        ];
    }
}
