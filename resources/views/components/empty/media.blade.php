@props([
    'variant' => 'default',
    'icon' => null,
])

@php
    $variant = in_array($variant, ['default', 'icon'], true) ? $variant : 'default';

    $variantClasses = match ($variant) {
        'icon' => "flex size-10 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-zinc-950 dark:bg-zinc-800 dark:text-zinc-50 [&_svg:not([class*='size-'])]:size-6",
        default => 'bg-transparent',
    };
@endphp

<div {{
    $attributes->class([
        'empty__media',
        'mb-2 flex shrink-0 items-center justify-center [&_svg]:pointer-events-none [&_svg]:shrink-0',
        $variantClasses,
    ])->merge([
        'data-empty-media' => true,
        'data-variant' => $variant,
    ])
}}>
    @if (filled($icon))
        <span aria-hidden="true">
            <x-stencil::icon :name="$icon" class="size-6" />
        </span>
    @endif
    {{ $slot }}
</div>
