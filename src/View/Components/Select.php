<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

final class Select extends StdComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = null,
        public mixed $placeholder = null,
        public mixed $size = null,
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $selectId = null,
        public mixed $listboxId = null,
        public bool $shortcut = true,
        public bool $multiple = false,
        public mixed $display = 'count',
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.select.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $invalid = $this->invalid || $fieldInvalid;
        $multiple = $this->multiple;
        $display = in_array($this->display, ['count', 'chips'], true) ? $this->display : 'count';

        if (! $multiple) {
            $display = 'count';
        }

        $selectId = filled($this->selectId)
            ? $this->selectId
            : (filled($this->name) ? $this->name : 'select-'.Str::uuid()->toString());
        $listboxId = filled($this->listboxId) ? $this->listboxId : $selectId.'-listbox';
        $controlId = $selectId;

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

        $rootAttributes = $this->attributes
            ->except('shortcut')
            ->class([
                'select relative min-w-0',
                'w-full' => ! filled($this->attributes->get('class')),
            ]);

        if ($multiple) {
            $rootAttributes = $rootAttributes->merge([
                'data-select-multiple' => true,
                'data-select-display' => $display,
                'data-select-count-template' => $countTemplate,
                'data-select-chip-remove-label' => $chipRemoveLabel,
            ]);
        }

        return [
            'invalid' => $invalid,
            'multiple' => $multiple,
            'display' => $display,
            'selectId' => $selectId,
            'listboxId' => $listboxId,
            'controlId' => $controlId,
            'fieldName' => $fieldName,
            'selectedValues' => $selectedValues,
            'scalarValue' => $scalarValue,
            'rootAttributes' => $rootAttributes,
        ];
    }
}
