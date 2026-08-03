<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\ColorPicker;

use Illuminate\Support\Facades\View;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Swatch extends StencilComponent
{
    public function __construct(
        public mixed $value = '#000000',
        public mixed $label = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.color-picker.swatch';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'disabled' => (bool) View::getConsumableComponentData('disabled', false),
            'swatchLabel' => filled($this->label) ? (string) $this->label : (string) $this->value,
        ];
    }
}
