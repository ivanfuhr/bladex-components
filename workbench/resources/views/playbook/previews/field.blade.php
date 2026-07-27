@php
    $orientation = $state['orientation'] ?? 'block';
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $invalid = (bool) ($state['invalid'] ?? false);
    $showDescription = (bool) ($state['show_description'] ?? true);
@endphp

<x-stencil::field name="email" :orientation="$orientation" :invalid="$invalid" class="max-w-md">
    <x-stencil::field.label>Email</x-stencil::field.label>
    <x-stencil::input name="email" type="email" placeholder="you@example.com" :size="$size" />
    @if ($showDescription)
        <x-stencil::field.description>We will never share your email.</x-stencil::field.description>
    @endif
    <x-stencil::field.errors name="email" />
</x-stencil::field>
