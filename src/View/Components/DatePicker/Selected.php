<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\DatePicker;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Selected extends StdComponent
{
    public function __construct(
        public mixed $placeholder = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.date-picker.selected';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'resolvedPlaceholder' => filled($this->placeholder) ? $this->placeholder : null,
        ];
    }
}
