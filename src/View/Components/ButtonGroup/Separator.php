<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\ButtonGroup;

use Illuminate\Support\Facades\View;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Separator extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.button-group.separator';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $explicit = $this->attributes->get('orientation');

        if (filled($explicit)) {
            $separatorOrientation = $explicit === 'horizontal' ? 'horizontal' : 'vertical';
            $attributes = $this->attributes->except('orientation');
        } else {
            $parentOrientation = View::getConsumableComponentData('orientation', 'horizontal');
            $parentOrientation = $parentOrientation === 'vertical' ? 'vertical' : 'horizontal';
            $separatorOrientation = $parentOrientation === 'vertical' ? 'horizontal' : 'vertical';
            $attributes = $this->attributes;
        }

        return [
            'attributes' => $attributes,
            'separatorOrientation' => $separatorOrientation,
        ];
    }
}
