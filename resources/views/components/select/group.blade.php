<div {{ $attributes->class(['select__group', 'flex flex-col gap-1'])->merge(['role' => 'group', 'data-select-group' => true]) }}>
    {{ $slot }}
</div>
