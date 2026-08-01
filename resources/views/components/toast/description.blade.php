<p {{
    $attributes->class([
        'toast__description',
        'text-sm opacity-80',
    ])->merge([
        'data-toast-description' => true,
    ])
}}>
    {{ $slot }}
</p>
