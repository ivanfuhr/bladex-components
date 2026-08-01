@php
    $emptyClasses = collect([
        'command__empty',
        'py-6 text-center text-sm text-zinc-500 dark:text-zinc-400',
    ])->implode(' ');
@endphp

<div {{
    $attributes->class($emptyClasses)->merge([
        'role' => 'presentation',
        'hidden' => true,
        'data-command-empty' => true,
    ])
}}>
    {{ $slot->isNotEmpty() ? $slot : __('stencil::messages.command_empty') }}
</div>
