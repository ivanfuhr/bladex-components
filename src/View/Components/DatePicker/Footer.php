<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\DatePicker;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Footer extends StdComponent
{
    public function __construct(
        public bool $range = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.date-picker.footer';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'confirmLabel' => $this->range
                ? __('Select range')
                : __('Select date'),
        ];
    }
}
