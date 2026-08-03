<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Select;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Content extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.select.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $size = $this->attributes->get('size') ?? stencil_ancestor_attribute('size');
        $listboxId = $this->attributes->get('listbox-id') ?? stencil_ancestor_attribute('listboxId');
        $multiple = (bool) ($this->attributes->get('multiple') ?? stencil_ancestor_attribute('multiple', false));

        $contentClasses = collect([
            'select__content',
            stencil_select_listbox_classes($size),
        ])->implode(' ');

        $contentAttributes = $this->attributes
            ->except(['size', 'listbox-id', 'multiple'])
            ->class($contentClasses)
            ->merge([
                'role' => 'listbox',
                'tabindex' => '-1',
                'hidden' => true,
            ])
            ->merge(['data-select-content' => '']);

        if ($multiple) {
            $contentAttributes = $contentAttributes->merge(['aria-multiselectable' => 'true']);
        }

        if (filled($listboxId)) {
            $contentAttributes = $contentAttributes->merge(['id' => $listboxId]);
        }

        return [
            'contentAttributes' => $contentAttributes,
        ];
    }
}
