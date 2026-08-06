<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\ComponentSlot;

final class SwitchControl extends StdComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = '1',
        public bool $checked = false,
        public bool $invalid = false,
        public mixed $size = null,
        public mixed $controlId = null,
        public mixed $label = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.switch.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $isInvalid = $this->invalid || $fieldInvalid || std_field_has_errors($this->name);

        $controlId = $this->attributes->get('id')
            ?? $this->controlId
            ?? (filled($this->name) ? $this->name : 'switch-'.Str::uuid()->toString());

        $rootClasses = std_switch_root_classes($this->size);
        $trackClasses = std_switch_track_classes($this->size);
        $thumbClasses = std_switch_thumb_classes($this->size);

        $wrapperClass = $this->attributes->get('class');

        $controlAttributes = std_apply_interaction($this->attributes
            ->except(['id', 'class'])
            ->class([
                'switch__input',
                'sr-only',
            ])
            ->merge([
                'type' => 'checkbox',
                'role' => 'switch',
                'id' => $controlId,
                'data-switch-control' => true,
            ]),
            nativeDisabled: true,
        );

        if (filled($this->name)) {
            $controlAttributes = $controlAttributes->merge(['name' => $this->name]);
        }

        if (filled($this->value)) {
            $controlAttributes = $controlAttributes->merge(['value' => $this->value]);
        }

        if ($this->checked) {
            $controlAttributes = $controlAttributes->merge(['checked' => true]);
        }

        $controlAttributes = $controlAttributes->merge([
            'aria-checked' => $this->checked ? 'true' : 'false',
        ]);

        if ($isInvalid) {
            $controlAttributes = $controlAttributes->merge(['aria-invalid' => 'true']);
        }

        $controlAttributes = std_merge_described_by($controlAttributes, $this->aware('describedBy'));

        $slot = $data['slot'] ?? null;
        $hasSlotLabel = $slot instanceof ComponentSlot ? ! $slot->isEmpty() : filled($slot);

        return [
            'rootClasses' => $rootClasses,
            'trackClasses' => $trackClasses,
            'thumbClasses' => $thumbClasses,
            'wrapperClass' => $wrapperClass,
            'controlAttributes' => $controlAttributes,
            'hasSlotLabel' => $hasSlotLabel,
        ];
    }
}
