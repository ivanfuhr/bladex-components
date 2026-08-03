<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Combobox;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Label extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.combobox.label';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $labelClasses = collect([
            'combobox__label',
            'px-2 pb-0.5 pt-1',
        ])->implode(' ');

        return [
            'labelClasses' => $labelClasses,
        ];
    }
}
