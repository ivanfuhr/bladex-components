<div {{
    $attributes->class([
        'collapsible',
        'w-full',
    ])->merge([
        'data-collapsible' => true,
        'data-state' => $isOpen ? 'open' : 'closed',
        'data-collapsible-transition' => $transition ? 'true' : 'false',
        'data-collapsible-disabled' => $isDisabled ? 'true' : null,
        'data-collapsible-trigger-id' => $triggerId,
        'data-collapsible-content-id' => $contentId,
    ])
}}>
    {{ $slot }}
</div>
