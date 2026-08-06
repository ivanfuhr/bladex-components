<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Select;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Item extends StdComponent
{
    public function __construct(
        public mixed $value = null,
        public bool $disabled = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.select.item';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $size = $this->attributes->get('size') ?? std_ancestor_attribute('size');
        $listboxId = std_ancestor_attribute('listboxId');

        $itemClasses = collect([
            'select__item',
            std_select_option_classes($size),
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

        if (filled($listboxId) && filled($this->value)) {
            $slug = preg_replace('/[^a-zA-Z0-9_-]/', '-', (string) $this->value) ?: 'option';

            $itemAttributes = $itemAttributes->merge([
                'id' => $listboxId.'-opt-'.$slug,
            ]);
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
