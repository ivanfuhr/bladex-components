<ul {{
    $attributes->class($listClasses)->merge([
        'data-file-upload-list' => true,
        'hidden' => true,
    ])
}}>
    {{ $slot }}
</ul>
