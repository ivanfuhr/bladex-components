<h5 {{
    $attributes->class([
        'alert__title',
        'font-medium leading-none tracking-tight',
    ])->merge([
        'data-alert-title' => true,
    ])
}}>
    {{ $slot }}
</h5>
