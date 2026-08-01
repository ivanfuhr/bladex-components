@aware([
    'size' => null,
    'invalid' => false,
    'fieldInvalid' => false,
    'disabled' => false,
    'currentValue' => '#000000',
    'popoverId' => null,
])

@props([
    'currentValue' => '#000000',
    'popoverId' => null,
    'invalid' => false,
    'disabled' => false,
    'size' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;

    $formControl = app(FormControlClassMap::class);
    $isInvalid = $invalid || $fieldInvalid;
    $isSmall = $size === 'sm';
    $swatchWidth = $isSmall ? 'w-9' : 'w-10';

    $triggerClasses = collect([
        'color-picker__trigger',
        'relative flex min-w-0 overflow-hidden rounded-md border border-zinc-200 bg-white shadow-sm transition-colors',
        'focus-within:outline-none focus-within:ring-2 focus-within:ring-zinc-950/10 focus-within:ring-offset-0',
        'dark:border-zinc-800 dark:bg-zinc-950 dark:focus-within:ring-zinc-300/20',
        $formControl->invalidFieldClasses(),
        $isInvalid ? 'border-red-500 focus-within:ring-red-500/20 dark:border-red-500' : null,
        $isSmall ? 'h-8' : 'h-9',
        $disabled ? 'opacity-50' : null,
    ])->filter()->implode(' ');

    $swatchButtonClasses = collect([
        'color-picker__swatch-trigger',
        'relative flex shrink-0 items-center justify-center border-r border-zinc-200 bg-zinc-50 p-1.5',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-zinc-950/10',
        'dark:border-zinc-800 dark:bg-zinc-900/80 dark:focus-visible:ring-zinc-300/20',
        $swatchWidth,
        $disabled ? 'cursor-not-allowed' : 'cursor-pointer',
    ])->filter()->implode(' ');

    $previewClasses = collect([
        'color-picker__preview',
        'block size-full min-h-[1.125rem] min-w-[1.125rem] rounded-[3px] ring-1 ring-inset ring-zinc-950/10 dark:ring-white/15',
        $isSmall ? 'min-h-4 min-w-4' : null,
    ])->filter()->implode(' ');
@endphp

<div @class([$triggerClasses]) data-color-picker-trigger>
    <button
        type="button"
        @class([$swatchButtonClasses])
        data-color-picker-swatch-trigger
        aria-label="{{ __('stencil::messages.color_picker_open') }}"
        @if (filled($popoverId)) aria-controls="{{ $popoverId }}" @endif
        aria-expanded="false"
        aria-haspopup="dialog"
        @if ($disabled) disabled @endif
    >
        <span
            class="{{ $previewClasses }}"
            data-color-picker-preview
            style="background-color: {{ $currentValue }}"
            aria-hidden="true"
        ></span>
    </button>

    {{ $slot }}
</div>
