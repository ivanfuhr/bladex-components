@php
    $badge = $state['badge'] ?? '';
    $required = (bool) ($state['required'] ?? false);
@endphp

<x-stencil::label for="email" :badge="$badge !== '' ? $badge : null" :required="$required">
    Email address
</x-stencil::label>
