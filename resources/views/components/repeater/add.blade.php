@aware([
    'disabled' => false,
])

@props([
    'disabled' => false,
])

@php
    $isDisabled = $disabled;

    $buttonClasses = collect([
        'repeater__add',
        'inline-flex w-fit items-center justify-center gap-2 rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm font-medium text-zinc-900 shadow-sm transition-colors',
        'hover:bg-zinc-50',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
        'disabled:pointer-events-none disabled:opacity-50',
        'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50 dark:hover:bg-zinc-900',
        'dark:focus-visible:ring-zinc-300/20',
    ])->implode(' ');

    $label = $slot->isEmpty()
        ? __('stencil::messages.repeater_add')
        : (string) $slot;

    $buttonAttributes = $attributes
        ->class($buttonClasses)
        ->merge([
            'type' => 'button',
            'data-repeater-add' => true,
        ]);

    if ($isDisabled) {
        $buttonAttributes = $buttonAttributes->merge(['disabled' => true]);
    }
@endphp

<button {{ $buttonAttributes }}>
    <x-stencil::icon name="plus" class="size-4" />
    <span>{{ $label }}</span>
</button>
