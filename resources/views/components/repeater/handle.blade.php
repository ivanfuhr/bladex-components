@aware([
    'disabled' => false,
])

@props([
    'disabled' => false,
])

@php
    $isDisabled = $disabled;

    $buttonClasses = collect([
        'repeater__handle',
        'inline-flex size-8 shrink-0 cursor-grab items-center justify-center rounded-md text-zinc-400 transition-colors',
        'hover:bg-zinc-100 hover:text-zinc-700',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
        'active:cursor-grabbing',
        'disabled:pointer-events-none disabled:opacity-50',
        'dark:text-zinc-500 dark:hover:bg-zinc-800 dark:hover:text-zinc-200',
        'dark:focus-visible:ring-zinc-300/20',
    ])->implode(' ');

    $buttonAttributes = $attributes
        ->class($buttonClasses)
        ->merge([
            'type' => 'button',
            'data-repeater-handle' => true,
            'aria-label' => __('stencil::messages.repeater_reorder'),
            'tabindex' => '-1',
        ]);

    if ($isDisabled) {
        $buttonAttributes = $buttonAttributes->merge(['disabled' => true]);
    }
@endphp

<button {{ $buttonAttributes }}>
    <x-stencil::icon name="grip-vertical" class="size-4" />
</button>
