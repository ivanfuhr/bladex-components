@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $length = (int) ($state['length'] ?? 6);
    $mode = ($state['mode'] ?? 'numeric') === 'alphanumeric' ? 'alphanumeric' : 'numeric';
    $separated = (bool) ($state['separated'] ?? true);
@endphp

<x-stencil::input-otp
    name="code"
    :length="$length"
    :mode="$mode"
    :separated="$separated"
    :invalid="$invalid"
    :disabled="$disabled"
    :size="$size"
/>
