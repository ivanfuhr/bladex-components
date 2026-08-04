<div {{
    $attributes->class([
        'alert',
        'relative w-full rounded-xl border px-4 py-3 text-sm',
        $variantClasses,
    ])->merge([
        'role' => $liveRole,
        'aria-live' => $liveMode,
        'aria-atomic' => 'true',
        'data-alert' => true,
        'data-variant' => $variant,
    ])
}}>
    <div class="flex gap-3">
        @if (filled($icon))
            <span class="mt-0.5 inline-flex shrink-0" data-alert-icon aria-hidden="true">
                <x-ui::icon :name="$icon" class="size-4" />
            </span>
        @endif
        <div class="min-w-0 flex-1 space-y-1">
            @if (filled($title))
                <x-ui::alert.title>{{ $title }}</x-ui::alert.title>
            @endif
            {{ $slot }}
        </div>
    </div>
</div>
