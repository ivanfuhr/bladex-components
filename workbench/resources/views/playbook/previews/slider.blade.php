@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $range = (bool) ($state['range'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $step = (int) ($state['step'] ?? 1);
    $value = $range ? [25, 75] : 40;
@endphp

<x-stencil::slider
    name="volume"
    :value="$value"
    :range="$range"
    :step="$step"
    :invalid="$invalid"
    :disabled="$disabled"
    :size="$size"
/>
