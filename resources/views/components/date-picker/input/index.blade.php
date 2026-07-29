@aware([
    'placeholder' => null,
    'invalid' => false,
    'disabled' => false,
    'clearable' => false,
    'size' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;

    $formControl = app(FormControlClassMap::class);
@endphp

<div class="date-picker__input-trigger flex w-full items-center gap-2" data-date-picker-trigger>
    <x-stencil::input
        {{ $attributes->merge([
            'type' => 'text',
            'placeholder' => $placeholder,
            'invalid' => $invalid,
            'disabled' => $disabled,
            'size' => $size,
            'readonly' => true,
            'data-date-picker-input' => true,
        ]) }}
    />
    @if ($clearable)
        <button
            type="button"
            class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800"
            data-date-picker-clear
            aria-label="{{ __('stencil::messages.date_picker_clear') }}"
        >
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
    @endif
</div>
