<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\Support\Str;
use InvalidArgumentException;

final class ColorPicker extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = null,
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $size = null,
        public mixed $swatches = null,
        public bool $dropper = false,
        public mixed $placeholder = null,
        public bool $shortcut = true,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.color-picker.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        if (! filled($this->name)) {
            throw new InvalidArgumentException('The color-picker component requires a [name] attribute.');
        }

        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $invalid = $this->invalid || $fieldInvalid;
        $currentValue = filled($this->value) ? (string) $this->value : '#000000';

        if (! preg_match('/^#[0-9a-fA-F]{6}$/', $currentValue)) {
            $currentValue = '#000000';
        }

        $defaultSwatches = [
            '#ef4444', '#f97316', '#f59e0b', '#eab308', '#84cc16', '#22c55e',
            '#10b981', '#14b8a6', '#06b6d4', '#0ea5e9', '#3b82f6', '#6366f1',
            '#8b5cf6', '#a855f7', '#d946ef', '#ec4899', '#f43f5e',
            '#fafafa', '#e4e4e7', '#a1a1aa', '#71717a', '#3f3f46', '#27272a', '#18181b',
        ];

        $showSwatches = $this->swatches !== false;
        $swatchPalette = match (true) {
            is_array($this->swatches) => collect($this->swatches)
                ->map(function (mixed $swatch): array {
                    if (is_array($swatch)) {
                        return [
                            'value' => (string) ($swatch[0] ?? $swatch['value'] ?? '#000000'),
                            'label' => (string) ($swatch[1] ?? $swatch['label'] ?? $swatch[0] ?? '#000000'),
                        ];
                    }

                    return [
                        'value' => (string) $swatch,
                        'label' => (string) $swatch,
                    ];
                })
                ->filter(fn (array $swatch) => preg_match('/^#[0-9a-fA-F]{6}$/', $swatch['value']) === 1)
                ->values()
                ->all(),
            default => collect($defaultSwatches)
                ->map(fn (string $color) => ['value' => $color, 'label' => $color])
                ->all(),
        };

        $pickerId = 'color-picker-'.Str::uuid()->toString();
        $popoverId = $pickerId.'-popover';
        $placeholderText = filled($this->placeholder) ? (string) $this->placeholder : '#000000';

        $rootAttributes = $this->attributes
            ->class([
                'color-picker',
                'group/color-picker relative flex min-w-0',
                'w-full' => ! filled($this->attributes->get('class')),
            ])
            ->merge([
                'data-color-picker' => true,
                'data-color-picker-id' => $pickerId,
            ]);

        if ($this->disabled) {
            $rootAttributes = $rootAttributes->merge(['data-disabled' => 'true']);
        }

        if ($invalid) {
            $rootAttributes = $rootAttributes->merge([
                'data-invalid' => 'true',
                'aria-invalid' => 'true',
            ]);
        }

        return [
            'invalid' => $invalid,
            'currentValue' => $currentValue,
            'showSwatches' => $showSwatches,
            'swatchPalette' => $swatchPalette,
            'popoverId' => $popoverId,
            'placeholderText' => $placeholderText,
            'rootAttributes' => $rootAttributes,
        ];
    }
}
