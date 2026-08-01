@aware([
    'variant' => null,
    'expanded' => false,
    'disabled' => false,
    'triggerId' => null,
    'contentId' => null,
])

@php
    $isExpanded = (bool) $expanded;
    $isDisabled = (bool) $disabled;
    $isReverse = $variant === 'reverse';
    $resolvedTriggerId = $triggerId ?? 'accordion-trigger-'.str_replace('.', '', uniqid('', true));
    $resolvedContentId = $contentId;
@endphp

<h3 class="accordion__heading m-0">
    <button
        type="button"
        {{
            $attributes->class([
                'accordion__trigger',
                'flex w-full items-center justify-between gap-3 px-4 py-3 text-left text-sm font-medium text-zinc-950',
                'transition-colors hover:bg-zinc-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-zinc-950/10',
                'disabled:pointer-events-none disabled:opacity-50',
                'dark:text-zinc-50 dark:hover:bg-zinc-900/60 dark:focus-visible:ring-zinc-300/20',
                $isReverse ? 'flex-row-reverse' : null,
            ])->merge([
                'id' => $resolvedTriggerId,
                'data-accordion-trigger' => true,
                'aria-expanded' => $isExpanded ? 'true' : 'false',
                'aria-controls' => filled($resolvedContentId) ? $resolvedContentId : null,
                'disabled' => $isDisabled ? true : null,
            ])
        }}
    >
        <span class="accordion__trigger-label min-w-0 flex-1">{{ $slot }}</span>
        <span
            class="accordion__trigger-icon [[data-state=open]_&]:rotate-180 inline-flex size-4 shrink-0 items-center justify-center text-zinc-500 transition-transform duration-200 dark:text-zinc-400"
            aria-hidden="true"
            data-accordion-icon
        >
            <x-stencil::icon name="chevron-down" class="size-4" />
        </span>
    </button>
</h3>
