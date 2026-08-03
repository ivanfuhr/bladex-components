<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Select;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Value extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.select.value';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $placeholder = $this->attributes->get('placeholder') ?? stencil_ancestor_attribute('placeholder');
        $resolvedPlaceholder = filled($placeholder) ? $placeholder : null;

        $valueClasses = collect([
            'select__value',
            'block min-w-0 flex-1 truncate',
            'data-placeholder:text-zinc-500 dark:data-placeholder:text-zinc-400',
        ])->implode(' ');

        return [
            'attributes' => $this->attributes->except('placeholder'),
            'resolvedPlaceholder' => $resolvedPlaceholder,
            'valueClasses' => $valueClasses,
        ];
    }
}
