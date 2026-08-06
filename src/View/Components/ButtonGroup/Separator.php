<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\ButtonGroup;

use Illuminate\Support\Facades\View;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Separator extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.button-group.separator';
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
