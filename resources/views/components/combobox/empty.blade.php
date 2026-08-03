<div {{
    $attributes->class($emptyClasses)->merge([
        'role' => 'presentation',
        'hidden' => true,
        'data-combobox-empty' => true,
    ])
}}>
    {{ $slot }}
</div>
