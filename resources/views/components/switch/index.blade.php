<div
    @class([
        'switch',
        $rootClasses,
        $size === 'sm' ? 'switch--sm' : null,
        $wrapperClass,
    ])
    data-switch
>
    <label class="inline-flex cursor-pointer items-center justify-center">
        <input {{ $controlAttributes }} />
        <span class="{{ $trackClasses }}" aria-hidden="true" data-switch-track>
            <span class="{{ $thumbClasses }}" data-switch-thumb></span>
        </span>
    </label>
</div>
