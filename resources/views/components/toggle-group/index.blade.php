@props([
    'type' => 'single',
    'variant' => 'default',
    'size' => null,
    'orientation' => 'horizontal',
    'spacing' => 0,
    'defaultValue' => null,
    'disabled' => false,
])

@php
    $type = $type === 'multiple' ? 'multiple' : 'single';
    $variant = in_array($variant, ['default', 'outline'], true) ? $variant : 'default';
    $size = match ($size) {
        'sm', 'lg' => $size,
        'xs' => 'sm',
        default => 'default',
    };
    $orientation = $orientation === 'vertical' ? 'vertical' : 'horizontal';
    $spacing = is_numeric($spacing) ? max(0, (int) $spacing) : 0;
    $isDisabled = (bool) $disabled;

    $initialValue = match (true) {
        is_array($defaultValue) => implode(',', array_map(static fn ($item): string => (string) $item, $defaultValue)),
        filled($defaultValue) => (string) $defaultValue,
        default => '',
    };

    $role = $type === 'single' ? 'radiogroup' : 'group';
@endphp

<div {{
    $attributes->class([
        'toggle-group',
        'group/toggle-group flex w-fit items-center rounded-md',
        $orientation === 'vertical' ? 'flex-col' : 'flex-row',
        $spacing > 0 ? 'gap-[length:var(--toggle-gap)]' : null,
        $spacing === 0 && $variant === 'outline' ? 'shadow-sm' : null,
    ])->merge([
        'role' => $role,
        'data-toggle-group' => true,
        'data-type' => $type,
        'data-variant' => $variant,
        'data-size' => $size,
        'data-orientation' => $orientation,
        'data-spacing' => (string) $spacing,
        'data-value' => $initialValue !== '' ? $initialValue : null,
        'data-disabled' => $isDisabled ? 'true' : null,
        'aria-disabled' => $isDisabled ? 'true' : null,
        'aria-orientation' => $orientation,
        'style' => $spacing > 0 ? '--toggle-gap: '.$spacing * 0.25.'rem' : null,
    ])
}}>
    {{ $slot }}
</div>
