<p {{
    $attributes->class([
        'toast__description',
        'text-sm',
    ])->merge([
        'data-toast-description' => true,
    ])
}}>
    {{ $slot }}
</p>
