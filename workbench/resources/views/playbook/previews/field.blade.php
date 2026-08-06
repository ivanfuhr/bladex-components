@php
    $orientation = $state['orientation'] ?? 'block';
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $invalid = (bool) ($state['invalid'] ?? false);
    $showDescription = (bool) ($state['show_description'] ?? true);
@endphp

<x-std::field name="email" :orientation="$orientation" :invalid="$invalid" class="max-w-md">
    <x-std::field.label>Email</x-std::field.label>
    <x-std::input name="email" type="email" placeholder="you@example.com" :size="$size" />
    @if ($showDescription)
        <x-std::field.description>We will never share your email.</x-std::field.description>
    @endif
    <x-std::field.errors name="email" />
</x-std::field>
