@props([
    'heading' => null,
])

@php
    $headingId = filled($heading)
        ? 'command-group-'.str_replace('.', '', uniqid('', true))
        : null;
@endphp

<div
    {{
        $attributes->class([
            'command__group',
            'overflow-hidden p-1 text-zinc-950 dark:text-zinc-50',
        ])->merge([
            'role' => 'group',
            'data-command-group' => true,
            'aria-labelledby' => $headingId,
        ])
    }}
>
    @if (filled($heading))
        <div
            id="{{ $headingId }}"
            class="command__group-heading px-2 py-1.5 text-xs font-medium text-zinc-500 dark:text-zinc-400"
            data-command-group-heading
            role="presentation"
        >
            {{ $heading }}
        </div>
    @endif
    {{ $slot }}
</div>
