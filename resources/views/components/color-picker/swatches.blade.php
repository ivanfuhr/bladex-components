@aware([
    'disabled' => false,
    'swatchPalette' => [],
])

@props([
    'swatches' => null,
    'swatchPalette' => [],
])

@php
    $palette = match (true) {
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
        default => collect($swatchPalette)
            ->map(function ($swatch) {
                if (is_array($swatch) && isset($swatch['value'])) {
                    return $swatch;
                }

                if (is_array($swatch)) {
                    return [
                        'value' => (string) ($swatch[0] ?? '#000000'),
                        'label' => (string) ($swatch[1] ?? $swatch[0] ?? '#000000'),
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
    };
@endphp

@if ($slot->isNotEmpty())
    <div
        class="color-picker__swatches grid grid-cols-8 gap-1.5"
        data-color-picker-swatches
        role="listbox"
        aria-label="{{ __('stencil::messages.color_picker_swatches') }}"
    >
        {{ $slot }}
    </div>
@elseif ($palette !== [])
    <div
        class="color-picker__swatches grid grid-cols-8 gap-1.5"
        data-color-picker-swatches
        role="listbox"
        aria-label="{{ __('stencil::messages.color_picker_swatches') }}"
    >
        @foreach ($palette as $swatch)
            <x-stencil::color-picker.swatch :value="$swatch['value']" :label="$swatch['label']" />
        @endforeach
    </div>
@endif
