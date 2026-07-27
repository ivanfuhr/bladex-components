@aware([
    'name' => null,
    'controlId' => null,
])

@php
    $for = $attributes->get('for') ?? $controlId ?? $name;
@endphp

<x-stencil::label :for="$for" {{ $attributes->except('for') }}>
    {{ $slot }}
</x-stencil::label>
