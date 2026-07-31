@php
    $emptyClasses = collect([
        'combobox__empty',
        'px-2 py-1.5 text-center text-sm text-zinc-500 dark:text-zinc-400',
    ])->implode(' ');
@endphp

<div {{
    $attributes->class($emptyClasses)->merge([
        'role' => 'presentation',
        'hidden' => true,
        'data-combobox-empty' => true,
    ])
}}>
    {{ $slot }}
</div>
