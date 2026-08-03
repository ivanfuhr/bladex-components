<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Select;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Item extends StencilComponent
{
    public function __construct(
        public mixed $value = null,
        public bool $disabled = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.select.item';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $size = $this->attributes->get('size') ?? stencil_ancestor_attribute('size');

        $itemClasses = collect([
            'select__item',
            stencil_select_option_classes($size),
            'aria-selected:font-medium',
            '[&[aria-selected=true]_[data-select-item-check]]:opacity-100',
        ])->implode(' ');

        $itemAttributes = $this->attributes
            ->except('size')
            ->class($itemClasses)
            ->merge([
                'role' => 'option',
                'data-select-item' => true,
                'aria-selected' => 'false',
                'tabindex' => '-1',
            ]);

        if (filled($this->value)) {
            $itemAttributes = $itemAttributes->merge(['data-value' => $this->value]);
        }

        if ($this->disabled) {
            $itemAttributes = $itemAttributes
                ->merge([
                    'data-disabled' => true,
                    'aria-disabled' => 'true',
                ]);
        }

        return [
            'itemAttributes' => $itemAttributes,
        ];
    }
}
