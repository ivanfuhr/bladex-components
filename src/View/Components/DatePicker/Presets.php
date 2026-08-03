<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\DatePicker;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Presets extends StencilComponent
{
    public function __construct(
        public mixed $presets = [],
        public mixed $presetMeta = [],
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.date-picker.presets';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'items' => $this->presets !== [] ? $this->presets : $this->presetMeta,
        ];
    }
}
