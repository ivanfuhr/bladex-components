@php
    $listClasses = collect([
        'file-upload__list',
        'flex flex-col gap-2',
    ])->implode(' ');
@endphp

<ul {{
    $attributes->class($listClasses)->merge([
        'data-file-upload-list' => true,
        'hidden' => true,
    ])
}}>
    {{ $slot }}
</ul>
