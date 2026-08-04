<main {{
    $attributes->class($classes)->merge([
        'data-main' => true,
    ])
}}>
    {{ $slot }}
</main>
