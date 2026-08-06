<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Combobox;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Label extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.combobox.label';
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
