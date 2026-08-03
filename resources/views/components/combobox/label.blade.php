<div {{
    $attributes->class($labelClasses)->merge([
        'role' => 'presentation',
        'data-combobox-label' => true,
    ])
}}>
    <x-ui::text size="sm" variant="subtle" inline class="text-xs">{{ $slot }}</x-ui::text>
</div>
