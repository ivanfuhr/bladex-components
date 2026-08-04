<x-ui::input {{
    $attributes->merge([
        'type' => 'text',
        'placeholder' => $placeholder,
        'invalid' => $invalid,
        'disabled' => $disabled,
        'size' => $size,
        'readonly' => true,
        'data-time-picker-trigger' => true,
        'data-time-picker-input' => true,
        'aria-haspopup' => 'listbox',
        'aria-expanded' => 'false',
    ])->merge(filled($listboxId) ? ['aria-controls' => $listboxId] : [])
}} />
