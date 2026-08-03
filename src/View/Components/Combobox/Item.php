<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Combobox;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Item extends StencilComponent
{
    public function __construct(
        public mixed $value = null,
        public bool $disabled = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.combobox.item';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $size = stencil_ancestor_attribute('size');
        $comboboxId = stencil_ancestor_attribute('comboboxId');
        $name = stencil_ancestor_attribute('name');

        $resolvedComboboxId = filled($comboboxId)
            ? $comboboxId
            : (filled($name) ? $name : null);

        $itemClasses = collect([
            'combobox__item',
            stencil_select_option_classes($size),
            'aria-selected:font-medium',
            '[&[aria-selected=true]_[data-combobox-item-check]]:opacity-100',
        ])->implode(' ');

        $optionId = filled($resolvedComboboxId) && filled($this->value)
            ? $resolvedComboboxId.'-option-'.preg_replace('/[^a-zA-Z0-9_-]/', '-', (string) $this->value)
            : null;

        $itemAttributes = $this->attributes
            ->class($itemClasses)
            ->merge([
                'role' => 'option',
                'data-combobox-item' => true,
                'aria-selected' => 'false',
                'tabindex' => '-1',
            ]);

        if (filled($optionId)) {
            $itemAttributes = $itemAttributes->merge(['id' => $optionId]);
        }

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
