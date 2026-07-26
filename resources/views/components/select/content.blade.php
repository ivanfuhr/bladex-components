@aware([
    'listboxId' => null,
    'size' => null,
])

@php
    use Ivanfuhr\BladexComponents\Support\Form\FormControlClassMap;

    $formControl = app(FormControlClassMap::class);

    $contentClasses = collect([
        'select__content',
        $formControl->selectListboxClasses($size),
    ])->implode(' ');

    $contentAttributes = $attributes
        ->class($contentClasses)
        ->merge([
            'role' => 'listbox',
            'tabindex' => '-1',
            'hidden' => true,
        ])
        ->merge(['data-select-content' => '']);

    if (filled($listboxId)) {
        $contentAttributes = $contentAttributes->merge(['id' => $listboxId]);
    }
@endphp

<div {{ $contentAttributes }}>
    {{ $slot }}
</div>
