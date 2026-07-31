@aware([
    'size' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;

    $formControl = app(FormControlClassMap::class);
    $railClasses = $formControl->sliderTrackClasses($size);
@endphp

<div {{
    $attributes->class($railClasses)->merge([
        'data-slider-track' => true,
    ])
}}>{{ $slot }}</div>
