<div {{
    $attributes->class($railClasses)->merge([
        'data-slider-track' => true,
    ])
}}>{{ $slot }}</div>
