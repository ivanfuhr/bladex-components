<div {{
    $attributes->class([
        'toast',
        'pointer-events-auto relative w-full rounded-xl border p-4 shadow-lg',
        $variantClasses,
        ! $open ? 'hidden' : null,
    ])->merge([
        'data-toast' => true,
        'data-variant' => $variant,
        'data-duration' => (string) $duration,
        'data-state' => $open ? 'open' : 'closed',
        'role' => $liveRole,
        'aria-live' => $liveMode,
        'aria-atomic' => 'true',
        'hidden' => $open ? null : true,
    ])
}}>
    <div class="flex items-start gap-3 pr-9">
        @if (filled($resolvedIcon))
            <span class="mt-0.5 inline-flex shrink-0" data-toast-icon aria-hidden="true">
                <x-ui::icon :name="$resolvedIcon" class="size-4" />
            </span>
        @endif
        <div class="min-w-0 flex-1 space-y-1">
            @if (filled($title))
                <x-ui::toast.title>{{ $title }}</x-ui::toast.title>
            @endif
            @if (filled($description))
                <x-ui::toast.description>{{ $description }}</x-ui::toast.description>
            @endif
            {{ $slot }}
        </div>
    </div>
    <x-ui::toast.close />
</div>
