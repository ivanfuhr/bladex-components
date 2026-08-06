<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Select;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Content extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.select.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $size = $this->attributes->get('size') ?? std_ancestor_attribute('size');
        $listboxId = $this->attributes->get('listbox-id') ?? std_ancestor_attribute('listboxId');
        $multiple = (bool) ($this->attributes->get('multiple') ?? std_ancestor_attribute('multiple', false));

        $contentClasses = collect([
            'select__content',
            std_select_listbox_classes($size),
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
