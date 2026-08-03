@php
    $orientation = $state['orientation'] ?? 'block';
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $invalid = (bool) ($state['invalid'] ?? false);
    $showDescription = (bool) ($state['show_description'] ?? true);
@endphp

<x-ui::field name="email" :orientation="$orientation" :invalid="$invalid" class="max-w-md">
    <x-ui::field.label>Email</x-ui::field.label>
    <x-ui::input name="email" type="email" placeholder="you@example.com" :size="$size" />
    @if ($showDescription)
        <x-ui::field.description>We will never share your email.</x-ui::field.description>
    @endif
    <x-ui::field.errors name="email" />
</x-ui::field>
