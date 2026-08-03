<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Combobox;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Content extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.combobox.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $listboxId = $this->attributes->get('listbox-id') ?? stencil_ancestor_attribute('listboxId');
        $comboboxId = stencil_ancestor_attribute('comboboxId');
        $name = stencil_ancestor_attribute('name');
        $size = $this->attributes->get('size') ?? stencil_ancestor_attribute('size');

        $resolvedComboboxId = filled($comboboxId)
            ? $comboboxId
            : (filled($name) ? $name : null);
        $resolvedListboxId = filled($listboxId)
            ? $listboxId
            : (filled($resolvedComboboxId) ? $resolvedComboboxId.'-listbox' : null);

        $contentClasses = collect([
            'combobox__content',
            stencil_select_listbox_classes($size),
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

        if (filled($resolvedListboxId)) {
            $contentAttributes = $contentAttributes->merge(['id' => $resolvedListboxId]);
        }

        return [
            'contentAttributes' => $contentAttributes,
        ];
    }
}
