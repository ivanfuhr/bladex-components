@props([])

@aware([
    'open' => false,
    'transition' => false,
])

@php
    $isOpen = (bool) $open;
@endphp

<div {{
    $attributes->class([
        'collapsible__content',
        'overflow-hidden text-sm text-zinc-600 dark:text-zinc-400',
        $transition
        ? 'motion-safe:transition-[grid-template-rows,opacity] motion-safe:duration-200 motion-safe:ease-[cubic-bezier(0.16,1,0.3,1)] grid'
        : null,
        $transition && $isOpen ? 'grid-rows-[1fr] opacity-100' : null,
        $transition && ! $isOpen ? 'grid-rows-[0fr] opacity-0' : null,
        ! $transition && ! $isOpen ? 'hidden' : null,
    ])->merge([
        'data-collapsible-content' => true,
        'data-state' => $isOpen ? 'open' : 'closed',
        'hidden' => (! $transition && ! $isOpen) ? true : null,
    ])
}}>
    <div class="collapsible__content-inner min-h-0" data-collapsible-content-inner>{{ $slot }}</div>
</div>
