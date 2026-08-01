@props([
    'pressed' => false,
    'variant' => 'default',
    'size' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $interactionState = app(InteractionStateAttributes::class);

    $variant = in_array($variant, ['default', 'outline'], true) ? $variant : 'default';
    $size = match ($size) {
        'sm', 'lg' => $size,
        'xs' => 'sm',
        default => 'default',
    };
    $isPressed = filter_var($pressed, FILTER_VALIDATE_BOOLEAN);

    $sizeClasses = match ($size) {
        'sm' => 'h-8 min-w-8 px-1.5 text-sm',
        'lg' => 'h-10 min-w-10 px-2.5 text-base',
        default => 'h-9 min-w-9 px-2 text-sm',
    };

    $variantClasses = match ($variant) {
        'outline' => implode(' ', [
            'border border-zinc-200 bg-transparent shadow-sm',
            'hover:bg-zinc-100 hover:text-zinc-900',
            'dark:border-zinc-800 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
        ]),
        default => implode(' ', [
            'bg-transparent',
            'hover:bg-zinc-100 hover:text-zinc-900',
            'dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
        ]),
    };

    $mergedAttributes = $interactionState->apply(
        $attributes
            ->class([
                'toggle',
                'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium',
                'transition-colors outline-none',
                'focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus-visible:ring-zinc-300/20',
                'disabled:pointer-events-none disabled:opacity-50',
                'cursor-pointer',
                '[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=size-])]:size-4',
                'data-[state=on]:bg-zinc-100 data-[state=on]:text-zinc-900',
                'dark:data-[state=on]:bg-zinc-800 dark:data-[state=on]:text-zinc-50',
                $sizeClasses,
                $variantClasses,
            ])
            ->merge([
                'type' => 'button',
                'data-toggle' => true,
                'data-variant' => $variant,
                'data-size' => $size,
                'data-state' => $isPressed ? 'on' : 'off',
                'aria-pressed' => $isPressed ? 'true' : 'false',
            ]),
        ['nativeDisabled' => true],
    );
@endphp

<button {{ $mergedAttributes }}>{{ $slot }}</button>
