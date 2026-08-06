<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Combobox;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Input extends StdComponent
{
    public function __construct(
        public mixed $placeholder = null,
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $size = null,
        public mixed $comboboxId = null,
        public mixed $listboxId = null,
        public mixed $controlId = null,
        public bool $multiple = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.combobox.input';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) $this->aware('fieldInvalid', false);
        $name = $this->aware('name');
        $awareSize = $data['size'] ?? $this->size;
        $awareInvalid = (bool) ($data['invalid'] ?? $this->invalid);
        $awareDisabled = (bool) ($data['disabled'] ?? $this->disabled);
        $awarePlaceholder = $data['placeholder'] ?? $this->placeholder;
        $awareComboboxId = $data['comboboxId'] ?? $this->comboboxId;
        $awareListboxId = $data['listboxId'] ?? $this->listboxId;
        $awareControlId = $data['controlId'] ?? $this->controlId;

        $isInvalid = $awareInvalid || $fieldInvalid || std_field_has_errors($name);
        $resolvedPlaceholder = filled($awarePlaceholder) ? $awarePlaceholder : null;

        $resolvedComboboxId = filled($awareComboboxId)
            ? $awareComboboxId
            : (filled($name) ? $name : null);
        $resolvedListboxId = filled($awareListboxId)
            ? $awareListboxId
            : (filled($resolvedComboboxId) ? $resolvedComboboxId.'-listbox' : null);
        $resolvedControlId = filled($awareControlId) ? $awareControlId : $resolvedComboboxId;

        $inputAttributes = std_apply_interaction($this->attributes
            ->except(['placeholder', 'invalid', 'disabled', 'size', 'comboboxId', 'listboxId', 'controlId'])
            ->class([
                'combobox__input',
                'group flex w-full min-w-0 !pr-9',
                std_field_surface_classes($awareSize, false, 'text'),
                'placeholder:text-zinc-500 dark:placeholder:text-zinc-400',
                std_invalid_field_classes(),
                'aria-expanded:border-zinc-300 aria-expanded:ring-2 aria-expanded:ring-zinc-950/10',
                'dark:aria-expanded:border-zinc-600 dark:aria-expanded:ring-zinc-300/20',
                $isInvalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
            ])
            ->merge([
                'type' => 'text',
                'role' => 'combobox',
                'aria-autocomplete' => 'list',
                'aria-expanded' => 'false',
                'aria-haspopup' => 'listbox',
                'autocomplete' => 'off',
                'spellcheck' => 'false',
            ]),
            nativeDisabled: true,
        );

        if ($isInvalid) {
            $inputAttributes = $inputAttributes->merge(['aria-invalid' => 'true']);
        }

        if ($awareDisabled) {
            $inputAttributes = $inputAttributes->merge(['disabled' => true]);
        }

        if (filled($resolvedPlaceholder)) {
            $inputAttributes = $inputAttributes->merge(['placeholder' => $resolvedPlaceholder]);
        }

        if (filled($resolvedControlId)) {
            $inputAttributes = $inputAttributes->merge(['id' => $resolvedControlId]);
        }

        if (filled($resolvedListboxId)) {
            $inputAttributes = $inputAttributes->merge(['aria-controls' => $resolvedListboxId]);
        }

        $chevronClasses = $awareSize === 'sm' ? 'size-3.5 shrink-0 opacity-50' : 'size-4 shrink-0 opacity-50';

        return [
            'isInvalid' => $isInvalid,
            'resolvedPlaceholder' => $resolvedPlaceholder,
            'resolvedListboxId' => $resolvedListboxId,
            'inputAttributes' => $inputAttributes,
            'chevronClasses' => $chevronClasses,
            'disabled' => $awareDisabled,
            'multiple' => $this->multiple,
        ];
    }
}
