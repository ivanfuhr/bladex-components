<button
    type="button"
    {{ $attributes->class(['dialog__close', 'inline-flex'])->merge([
        'data-dialog-close' => true,
    ]) }}
>
    {{ $slot }}
</button>
