@props([
    'name' => null,
])

<div {{
    $attributes->class([
        'dialog__trigger',
        'contents',
    ])->merge([
        'data-dialog-trigger' => true,
        'data-dialog-name' => filled($name) ? $name : null,
    ])
}}>
    {{ $slot }}
</div>
