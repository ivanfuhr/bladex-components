@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
@endphp

<x-ui::color-picker
    name="brand_color"
    value="#3366cc"
    :invalid="$invalid"
    :disabled="$disabled"
    class="w-full max-w-xs"
/>
