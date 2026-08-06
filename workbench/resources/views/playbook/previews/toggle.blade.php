@php
    $variant = ($state['variant'] ?? 'default') === 'outline' ? 'outline' : 'default';
    $size = ($state['size'] ?? 'default') === 'default' ? null : (string) $state['size'];
    $pressed = (bool) ($state['pressed'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
@endphp

<x-std::toggle :variant="$variant" :size="$size" :pressed="$pressed" :disabled="$disabled" aria-label="Toggle italic">
    Italic
</x-std::toggle>
