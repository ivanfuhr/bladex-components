@aware([
    'disabled' => false,
])

@props([
    'disabled' => false,
])

@php
    $isDisabled = $disabled;

    $buttonClasses = collect([
        'repeater__duplicate',
        'inline-flex size-8 shrink-0 items-center justify-center rounded-md text-zinc-500 transition-colors',
        'hover:bg-zinc-100 hover:text-zinc-900',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
        'disabled:pointer-events-none disabled:opacity-50',
        'dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
        'dark:focus-visible:ring-zinc-300/20',
    ])->implode(' ');

    $buttonAttributes = $attributes
        ->class($buttonClasses)
        ->merge([
            'type' => 'button',
            'data-repeater-duplicate' => true,
            'aria-label' => __('stencil::messages.repeater_duplicate'),
        ]);

    if ($isDisabled) {
        $buttonAttributes = $buttonAttributes->merge(['disabled' => true]);
    }
@endphp

<button {{ $buttonAttributes }}>
    <x-stencil::icon name="copy" class="size-4" />
</button>
