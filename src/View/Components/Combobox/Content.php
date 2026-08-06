<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Combobox;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Content extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.combobox.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $listboxId = $this->attributes->get('listbox-id') ?? std_ancestor_attribute('listboxId');
        $comboboxId = std_ancestor_attribute('comboboxId');
        $name = std_ancestor_attribute('name');
        $size = $this->attributes->get('size') ?? std_ancestor_attribute('size');

        $resolvedComboboxId = filled($comboboxId)
            ? $comboboxId
            : (filled($name) ? $name : null);
        $resolvedListboxId = filled($listboxId)
            ? $listboxId
            : (filled($resolvedComboboxId) ? $resolvedComboboxId.'-listbox' : null);

        $contentClasses = collect([
            'combobox__content',
            std_select_listbox_classes($size),
        ])->implode(' ');

        $contentAttributes = $this->attributes
            ->except(['listbox-id', 'size'])
            ->class($contentClasses)
            ->merge([
                'role' => 'listbox',
                'tabindex' => '-1',
                'hidden' => true,
            ])
            ->merge(['data-combobox-content' => '']);

        $multiple = (bool) std_ancestor_attribute('multiple', false);

        if ($multiple) {
            $contentAttributes = $contentAttributes->merge(['aria-multiselectable' => 'true']);
        }

        if (filled($resolvedListboxId)) {
            $contentAttributes = $contentAttributes->merge(['id' => $resolvedListboxId]);
        }

        return [
            'contentAttributes' => $contentAttributes,
        ];
    }
}
