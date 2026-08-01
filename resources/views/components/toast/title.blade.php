<p {{
    $attributes->class([
        'toast__title',
        'text-sm font-semibold',
    ])->merge([
        'data-toast-title' => true,
    ])
}}>
    {{ $slot }}
</p>
