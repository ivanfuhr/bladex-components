@props([
    'name' => null,
    'value' => null,
    'invalid' => false,
    'disabled' => false,
    'size' => null,
    'swatches' => null,
    'dropper' => false,
    'placeholder' => null,
    'shortcut' => true,
])

@aware([
    'fieldInvalid' => false,
])

@php
    if (! filled($name)) {
        throw new \InvalidArgumentException('The color-picker component requires a [name] attribute.');
    }

    $invalid = $invalid || $fieldInvalid;
    $currentValue = filled($value) ? (string) $value : '#000000';

    if (! preg_match('/^#[0-9a-fA-F]{6}$/', $currentValue)) {
        $currentValue = '#000000';
    }

    $defaultSwatches = [
        '#ef4444', '#f97316', '#f59e0b', '#eab308', '#84cc16', '#22c55e',
        '#10b981', '#14b8a6', '#06b6d4', '#0ea5e9', '#3b82f6', '#6366f1',
        '#8b5cf6', '#a855f7', '#d946ef', '#ec4899', '#f43f5e',
        '#fafafa', '#e4e4e7', '#a1a1aa', '#71717a', '#3f3f46', '#27272a', '#18181b',
    ];

    $showSwatches = $swatches !== false;
    $swatchPalette = match (true) {
        is_array($swatches) => collect($swatches)
            ->map(function ($swatch) {
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

    $pickerId = 'color-picker-'.str_replace('.', '', uniqid('', true));
    $popoverId = $pickerId.'-popover';
    $placeholderText = filled($placeholder) ? (string) $placeholder : '#000000';

    $rootAttributes = $attributes
        ->except(['name', 'value', 'invalid', 'disabled', 'size', 'swatches', 'dropper', 'placeholder', 'shortcut'])
        ->class([
            'color-picker',
            'group/color-picker relative flex min-w-0',
            'w-full' => ! filled($attributes->get('class')),
        ])
        ->merge([
            'data-color-picker' => true,
            'data-color-picker-id' => $pickerId,
        ]);

    if ($disabled) {
        $rootAttributes = $rootAttributes->merge(['data-disabled' => 'true']);
    }

    if ($invalid) {
        $rootAttributes = $rootAttributes->merge([
            'data-invalid' => 'true',
            'aria-invalid' => 'true',
        ]);
    }
@endphp

<div {{ $rootAttributes }}>
    <input type="hidden" name="{{ $name }}" value="{{ $currentValue }}" data-color-picker-hidden-input />

    @if ($shortcut)
        <x-stencil::color-picker.trigger
            :current-value="$currentValue"
            :popover-id="$popoverId"
            :$disabled
            :$invalid
            :$size
        >
            <x-stencil::color-picker.hex
                :current-value="$currentValue"
                :popover-id="$popoverId"
                :placeholder-text="$placeholderText"
                :$disabled
                :$invalid
                :$size
            />
        </x-stencil::color-picker.trigger>

        <x-stencil::color-picker.content :popover-id="$popoverId">
            <x-stencil::color-picker.area />

            <div class="flex items-center gap-2">
                <div class="relative min-w-0 flex-1">
                    <x-stencil::color-picker.hue :$disabled />
                </div>

                @if ($dropper)
                    <x-stencil::color-picker.dropper :$disabled />
                @endif
            </div>

            @if ($showSwatches && $swatchPalette !== [])
                <x-stencil::color-picker.swatches :swatch-palette="$swatchPalette" :$disabled />
            @endif
        </x-stencil::color-picker.content>
    @else
        {{ $slot }}
    @endif
</div>
