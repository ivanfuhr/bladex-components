@php
    $size = $state['size'] === 'default' ? null : $state['size'];
    $variant = $state['variant'] === 'default' ? null : $state['variant'];
    $color = $state['color'] === 'default' ? null : $state['color'];
    $inline = (bool) ($state['inline'] ?? false);
@endphp

<x-bladex-components::text
    :size="$size"
    :variant="$variant"
    :color="$color"
    :inline="$inline"
>
    Body copy with the configured size, variant, and color.
</x-bladex-components::text>
