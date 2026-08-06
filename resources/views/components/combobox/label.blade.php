<div {{
    $attributes->class($labelClasses)->merge([
        'role' => 'presentation',
        'data-combobox-label' => true,
    ])
}}>
    <x-std::text size="sm" variant="subtle" inline class="text-xs">{{ $slot }}</x-std::text>
</div>
