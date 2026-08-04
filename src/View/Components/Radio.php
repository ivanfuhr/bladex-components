<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\ComponentSlot;

final class Radio extends StencilComponent
{
    public function __construct(
        public mixed $value = null,
        public bool $checked = false,
        public bool $invalid = false,
        public mixed $size = null,
        public mixed $label = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.radio.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $name = stencil_ancestor_attribute('name');
        $fieldInvalid = (bool) stencil_ancestor_attribute('fieldInvalid', false);
        $isInvalid = $this->invalid || $fieldInvalid || stencil_field_has_errors($name);

        $controlId = $this->attributes->get('id') ?? 'radio-'.Str::uuid()->toString();

        // Checked border utilities live in FormControlClassMap (Support is @source'd).
        $controlClasses = stencil_radio_control_classes($this->size);

        $controlAttributes = stencil_apply_interaction($this->attributes
            ->except('id')
            ->class($controlClasses)
            ->merge([
                'type' => 'radio',
                'id' => $controlId,
                'data-radio-control' => true,
            ]),
            nativeDisabled: true,
        );

        if (filled($name)) {
            $controlAttributes = $controlAttributes->merge(['name' => $name]);
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

        $slot = $data['slot'] ?? null;
        $hasSlotLabel = $slot instanceof ComponentSlot ? ! $slot->isEmpty() : filled($slot);

        return [
            'controlId' => $controlId,
            'controlAttributes' => $controlAttributes,
            'hasSlotLabel' => $hasSlotLabel,
        ];
    }
}
