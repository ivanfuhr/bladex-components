<div
    {{
        $attributes->class($rangeClasses)->merge([
            'data-slider-range' => true,
            'style' => 'left: '.$rangeStart.'%; width: '.max(0, $rangeEnd - $rangeStart).'%;',
        ])
    }}
></div>
