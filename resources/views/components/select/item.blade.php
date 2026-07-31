@props([
    'value' => null,
    'disabled' => false,
])

@aware([
    'size' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;

    $formControl = app(FormControlClassMap::class);

    $itemClasses = collect([
        'select__item',
        $formControl->selectOptionClasses($size),
        'aria-selected:font-medium',
        '[&[aria-selected=true]_[data-select-item-check]]:opacity-100',
    ])->implode(' ');

    $itemAttributes = $attributes
        ->class($itemClasses)
        ->merge([
            'role' => 'option',
            'data-select-item' => true,
            'aria-selected' => 'false',
            'tabindex' => '-1',
        ]);

    if (filled($value)) {
        $itemAttributes = $itemAttributes->merge(['data-value' => $value]);
    }

    if ($disabled) {
        $itemAttributes = $itemAttributes
            ->merge([
                'data-disabled' => true,
                'aria-disabled' => 'true',
            ]);
    }
@endphp

<div {{ $itemAttributes }}>
    <span class="min-w-0 flex-1 truncate" data-select-item-label>{{ $slot }}</span>
    <svg
        class="pointer-events-none absolute top-1/2 right-2 size-4 -translate-y-1/2 text-zinc-900 opacity-0 dark:text-zinc-50"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        aria-hidden="true"
        data-select-item-check
    >
        <path d="M20 6 9 17l-5-5" />
    </svg>
</div>
