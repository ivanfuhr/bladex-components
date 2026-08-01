@aware([
    'transition' => false,
    'expanded' => false,
    'triggerId' => null,
    'contentId' => null,
])

@php
    $isExpanded = (bool) $expanded;
    $resolvedContentId = $contentId ?? 'accordion-content-'.str_replace('.', '', uniqid('', true));
@endphp

<div {{
    $attributes->class([
        'accordion__content',
        'overflow-hidden text-sm text-zinc-600 dark:text-zinc-400',
        $transition
        ? 'grid motion-safe:transition-[grid-template-rows,opacity] motion-safe:duration-200 motion-safe:ease-[cubic-bezier(0.16,1,0.3,1)]'
        : null,
        $transition && $isExpanded ? 'grid-rows-[1fr] opacity-100' : null,
        $transition && ! $isExpanded ? 'grid-rows-[0fr] opacity-0' : null,
        ! $transition && ! $isExpanded ? 'hidden' : null,
    ])->merge([
        'id' => $resolvedContentId,
        'role' => 'region',
        'aria-labelledby' => filled($triggerId) ? $triggerId : null,
        'data-accordion-content' => true,
        'data-state' => $isExpanded ? 'open' : 'closed',
        'hidden' => (! $transition && ! $isExpanded) ? true : null,
        'inert' => ($transition && ! $isExpanded) ? true : null,
        'aria-hidden' => ($transition && ! $isExpanded) ? 'true' : null,
    ])
}}>
    <div class="accordion__content-inner min-h-0 px-4 pb-4" data-accordion-content-inner>{{ $slot }}</div>
</div>
