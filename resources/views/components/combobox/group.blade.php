<div {{ $attributes->class(['combobox__group', 'flex flex-col gap-1'])->merge(['role' => 'group', 'data-combobox-group' => true]) }}>
    {{ $slot }}
</div>
