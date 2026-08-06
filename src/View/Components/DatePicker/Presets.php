<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\DatePicker;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Presets extends StdComponent
{
    public function __construct(
        public mixed $presets = [],
        public mixed $presetMeta = [],
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.date-picker.presets';
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
