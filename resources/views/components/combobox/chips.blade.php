<div {{
    $attributes->class([
        'combobox__chips',
        'flex min-w-0 flex-1 flex-wrap items-center gap-1',
    ])->merge([
        'data-combobox-chips' => true,
        'data-placeholder' => $resolvedPlaceholder !== null ? $resolvedPlaceholder : null,
    ])
}}>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @endif
</div>

<template data-combobox-chip-template>
    <span class="{{ $chipClasses }}" data-combobox-chip>
        <span class="{{ $chipLabelClasses }}" data-combobox-chip-label></span>
        <button
            type="button"
            class="{{ $chipRemoveClasses }}"
            data-combobox-chip-remove
            aria-label="{{ __('Remove') }}"
        >
            <x-std::icon name="x" class="{{ $size === 'sm' ? 'size-3' : 'size-3.5' }}" />
        </button>
    </span>
</template>
