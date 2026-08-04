<div
    @class([
        'switch',
        $rootClasses,
        $size === 'sm' ? 'switch--sm' : null,
        $wrapperClass,
    ])
    data-switch
>
    <label class="inline-flex cursor-pointer items-center gap-2">
        <input {{ $controlAttributes }} />
        <span class="{{ $trackClasses }}" aria-hidden="true" data-switch-track>
            <span class="{{ $thumbClasses }}" data-switch-thumb></span>
        </span>
        @if ($hasSlotLabel)
            <span class="text-sm font-medium text-zinc-900 dark:text-zinc-50">{{ $slot }}</span>
        @elseif (filled($label))
            <span class="text-sm font-medium text-zinc-900 dark:text-zinc-50">{{ $label }}</span>
        @endif
    </label>
</div>
