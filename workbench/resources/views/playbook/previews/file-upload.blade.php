@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $multiple = (bool) ($state['multiple'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $accept = filled($state['accept'] ?? null) ? (string) $state['accept'] : null;
@endphp

<x-ui::file-upload
    name="attachments"
    :accept="$accept"
    :multiple="$multiple"
    :invalid="$invalid"
    :disabled="$disabled"
    :size="$size"
    text="PNG, JPG, or PDF up to 10MB"
    class="w-full max-w-md"
/>
