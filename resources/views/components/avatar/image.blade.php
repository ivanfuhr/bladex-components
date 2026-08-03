<img {{
    $attributes->class([
        'avatar__image',
        'aspect-square size-full object-cover',
    ])->merge([
        'src' => $src,
        'alt' => $alt,
        'data-avatar-image' => true,
    ])
}} />
