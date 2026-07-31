@aware([
    'listboxId' => null,
    'comboboxId' => null,
    'name' => null,
    'size' => null,
])

@props([
    'listboxId' => null,
    'size' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;

    $formControl = app(FormControlClassMap::class);

    $resolvedComboboxId = filled($comboboxId)
        ? $comboboxId
        : (filled($name) ? $name : null);
    $resolvedListboxId = filled($listboxId)
        ? $listboxId
        : (filled($resolvedComboboxId) ? $resolvedComboboxId.'-listbox' : null);

    $contentClasses = collect([
        'combobox__content',
        $formControl->selectListboxClasses($size),
    ])->implode(' ');

    $contentAttributes = $attributes
        ->except(['listboxId', 'size'])
        ->class($contentClasses)
        ->merge([
            'role' => 'listbox',
            'tabindex' => '-1',
            'hidden' => true,
        ])
        ->merge(['data-combobox-content' => '']);

    if (filled($resolvedListboxId)) {
        $contentAttributes = $contentAttributes->merge(['id' => $resolvedListboxId]);
    }
@endphp

<div {{ $contentAttributes }}>{{ $slot }}</div>
