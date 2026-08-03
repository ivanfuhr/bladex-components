@php
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
@endphp

<x-ui::textarea
    name="bio"
    placeholder="Tell us about yourself…"
    rows="4"
    :size="$size"
    :invalid="$invalid"
    :disabled="$disabled"
/>
