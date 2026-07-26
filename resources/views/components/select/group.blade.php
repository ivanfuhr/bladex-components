<div
    {{ $attributes->class(['select__group', 'py-1'])->merge(['role' => 'group', 'data-select-group' => true]) }}
>
    {{ $slot }}
</div>
