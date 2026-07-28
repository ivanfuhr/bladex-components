@props([
    'name' => null,
])

<div
    {{ $attributes->class(['dialog', 'contents']) }}
    data-dialog
    @if (filled($name))
        data-dialog-name="{{ $name }}"
    @endif
>
    {{ $slot }}
</div>
