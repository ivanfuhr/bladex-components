@props([
    'position' => 'bottom-right',
])

@php
    $positionClasses = match ($position) {
        'top-left' => 'left-4 top-4 items-start',
        'top-center' => 'left-1/2 top-4 -translate-x-1/2 items-center',
        'top-right' => 'right-4 top-4 items-end',
        'bottom-left' => 'bottom-4 left-4 items-start',
        'bottom-center' => 'bottom-4 left-1/2 -translate-x-1/2 items-center',
        default => 'bottom-4 right-4 items-end',
    };
@endphp

<div {{
    $attributes->class([
        'toast-provider',
        'pointer-events-none fixed z-[400] flex w-full max-w-sm flex-col gap-2',
        $positionClasses,
    ])->merge([
        'data-toast-provider' => true,
        'data-position' => $position,
        'aria-live' => 'polite',
        'aria-relevant' => 'additions text',
    ])
}}>
    {{ $slot }}
</div>
