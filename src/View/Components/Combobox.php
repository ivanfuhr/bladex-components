<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

final class Combobox extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = null,
        public mixed $placeholder = null,
        public mixed $empty = null,
        public mixed $size = null,
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $comboboxId = null,
        public mixed $listboxId = null,
        public bool $shortcut = true,
        public bool $multiple = false,
        public mixed $display = 'count',
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.combobox.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) $this->aware('fieldInvalid', false);
        $invalid = $this->invalid || $fieldInvalid || stencil_field_has_errors($this->name);
        $multiple = $this->multiple;
        $display = in_array($this->display, ['count', 'chips'], true) ? $this->display : 'count';

        if (! $multiple) {
            $display = 'count';
        }

        $comboboxId = filled($this->comboboxId)
            ? $this->comboboxId
            : (filled($this->name) ? $this->name : 'combobox-'.Str::uuid()->toString());
        $listboxId = filled($this->listboxId) ? $this->listboxId : $comboboxId.'-listbox';
        $controlId = filled($this->aware('controlId')) ? $this->aware('controlId') : $comboboxId;

        $fieldName = $this->name;

        if ($multiple && filled($this->name) && ! Str::endsWith($this->name, '[]')) {
            $fieldName = $this->name.'[]';
        }

        $selectedValues = $multiple
            ? collect(Arr::wrap($this->value))
                ->filter(fn (mixed $item): bool => filled($item))
                ->map(fn (mixed $item): string => (string) $item)
                ->values()
                ->all()
            : [];

        $scalarValue = $multiple ? null : (filled($this->value) ? (string) $this->value : '');

        $countTemplate = __('{count} selected', ['count' => '{count}']);
        $chipRemoveLabel = __('Remove');

        $emptyMessage = filled($this->empty)
            ? (string) $this->empty
            : __('No results found.');

        $rootAttributes = $this->attributes
            ->except('shortcut')
            ->class([
                'combobox relative min-w-0',
                'w-full' => ! filled($this->attributes->get('class')),
            ]);

        if ($multiple) {
            $rootAttributes = $rootAttributes->merge([
                'data-combobox-multiple' => true,
                'data-combobox-display' => $display,
                'data-combobox-count-template' => $countTemplate,
                'data-combobox-chip-remove-label' => $chipRemoveLabel,
            ]);
        }

        return [
            'resolvedInvalid' => $invalid,
            'multiple' => $multiple,
            'display' => $display,
            'comboboxId' => $comboboxId,
            'listboxId' => $listboxId,
            'controlId' => $controlId,
            'fieldName' => $fieldName,
            'selectedValues' => $selectedValues,
            'scalarValue' => $scalarValue,
            'emptyMessage' => $emptyMessage,
            'rootAttributes' => $rootAttributes,
        ];
    }
}
