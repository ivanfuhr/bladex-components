<div {{
    $attributes->class($emptyClasses)->merge([
        'role' => 'presentation',
        'hidden' => true,
        'data-command-empty' => true,
    ])
}}>
    {{ $slot->isNotEmpty() ? $slot : __('No results found.') }}
</div>
