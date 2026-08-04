<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Checkbox extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = '1',
        public bool $checked = false,
        public bool $invalid = false,
        public mixed $size = null,
        public mixed $controlId = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.checkbox.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $isInvalid = $this->invalid || $fieldInvalid || stencil_field_has_errors($this->attributes->get('name') ?? $this->name);

        $resolvedControlId = $this->attributes->get('id')
            ?? $this->controlId
            ?? $this->attributes->get('controlId')
            ?? (filled($this->name) ? $this->name : null);

        // Checkmark SVG is applied in stencil.css — Tailwind does not emit
        // checked:bg-[url(data:...)] when the class lives only inside a PHP string.
        // Checked fill utilities live in FormControlClassMap (Support is @source'd).
        $controlClasses = stencil_checkbox_control_classes($this->size);

        $controlAttributes = stencil_apply_interaction($this->attributes
            ->except(['id'])
            ->class($controlClasses)
            ->merge([
                'type' => 'checkbox',
                'data-checkbox-control' => true,
            ]),
            nativeDisabled: true,
        );

        if (filled($resolvedControlId)) {
            $controlAttributes = $controlAttributes->merge(['id' => $resolvedControlId]);
        }

        if (filled($this->name)) {
            $controlAttributes = $controlAttributes->merge(['name' => $this->name]);
        }

        if (filled($this->value)) {
            $controlAttributes = $controlAttributes->merge(['value' => $this->value]);
        }

        if ($this->checked) {
            $controlAttributes = $controlAttributes->merge(['checked' => true]);
        }

        if ($isInvalid) {
            $controlAttributes = $controlAttributes->merge(['aria-invalid' => 'true']);
        }

        $controlAttributes = stencil_merge_described_by($controlAttributes, $this->aware('describedBy'));

        return [
            'fieldInvalid' => $fieldInvalid,
            'controlAttributes' => $controlAttributes,
        ];
    }
}
