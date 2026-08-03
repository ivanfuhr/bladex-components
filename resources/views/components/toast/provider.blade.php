<div {{
    $attributes->class([
        'toast-provider',
        'pointer-events-none fixed z-[400] flex w-full max-w-sm flex-col gap-2',
        $positionClasses,
    ])->merge([
        'data-toast-provider' => true,
        'data-position' => $position,
        // Live region lives on each toast (role=status|alert) to avoid nested announcements.
        'data-toast-dismiss-label' => __('Dismiss'),
    ])
}}>
    {{ $slot }}
</div>
