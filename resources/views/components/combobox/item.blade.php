@props([
    'value' => null,
    'disabled' => false,
])

@aware([
    'size' => null,
    'comboboxId' => null,
    'name' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;

    $formControl = app(FormControlClassMap::class);

    $resolvedComboboxId = filled($comboboxId)
        ? $comboboxId
        : (filled($name) ? $name : null);

    $itemClasses = collect([
        'combobox__item',
        $formControl->selectOptionClasses($size),
        'aria-selected:font-medium',
        '[&[aria-selected=true]_[data-combobox-item-check]]:opacity-100',
    ])->implode(' ');

    $optionId = filled($resolvedComboboxId) && filled($value)
        ? $resolvedComboboxId.'-option-'.preg_replace('/[^a-zA-Z0-9_-]/', '-', (string) $value)
        : null;

    $itemAttributes = $attributes
        ->class($itemClasses)
        ->merge([
            'role' => 'option',
            'data-combobox-item' => true,
            'aria-selected' => 'false',
            'tabindex' => '-1',
        ]);

    if (filled($optionId)) {
        $itemAttributes = $itemAttributes->merge(['id' => $optionId]);
    }

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
    <span class="min-w-0 flex-1 truncate" data-combobox-item-label>{{ $slot }}</span>
    <x-stencil::icon
        name="check"
        class="pointer-events-none absolute top-1/2 right-2 size-4 -translate-y-1/2 text-zinc-900 opacity-0 dark:text-zinc-50"
        data-combobox-item-check
    />
</div>
