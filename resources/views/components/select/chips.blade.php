<div {{
    $attributes->class([
        'select__chips',
        'flex min-w-0 flex-1 flex-wrap items-center gap-1',
    ])->merge([
        'data-select-chips' => true,
        'data-placeholder' => $resolvedPlaceholder !== null ? $resolvedPlaceholder : null,
    ])
}}>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @endif
</div>

<template data-select-chip-template>
    <span class="{{ $chipClasses }}" data-select-chip>
        <span class="{{ $chipLabelClasses }}" data-select-chip-label></span>
        <button type="button" class="{{ $chipRemoveClasses }}" data-select-chip-remove aria-label="{{ __('Remove') }}">
            <x-ui::icon name="x" class="{{ $size === 'sm' ? 'size-3' : 'size-3.5' }}" />
        </button>
    </span>
</template>
