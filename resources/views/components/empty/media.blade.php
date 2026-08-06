<div {{
    $attributes->class([
        'empty__media',
        'mb-2 flex shrink-0 items-center justify-center [&_svg]:pointer-events-none [&_svg]:shrink-0',
        $variantClasses,
    ])->merge([
        'data-empty-media' => true,
        'data-variant' => $resolvedVariant,
    ])
}}>
    @if (filled($icon))
        <span aria-hidden="true">
            <x-std::icon :name="$icon" class="size-6" />
        </span>
    @endif
    {{ $slot }}
</div>
