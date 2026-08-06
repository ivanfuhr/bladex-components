<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Select;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Value extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.select.value';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $placeholder = $this->attributes->get('placeholder') ?? std_ancestor_attribute('placeholder');
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
