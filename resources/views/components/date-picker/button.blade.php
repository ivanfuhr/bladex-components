@aware([
    'placeholder' => null,
    'invalid' => false,
    'disabled' => false,
    'clearable' => false,
    'size' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $triggerAttributes = $interactionState->apply(
        $attributes
            ->class([
                'date-picker__trigger',
                'group flex w-full min-w-0 items-center justify-between gap-2 text-left',
                $formControl->fieldSurfaceClasses($size, includeReadOnly: false, cursor: 'pointer'),
                $formControl->invalidFieldClasses(),
                $invalid ? 'border-red-500' : null,
            ])
            ->merge([
                'type' => 'button',
                'aria-haspopup' => 'dialog',
                'aria-expanded' => 'false',
            ]),
        ['nativeDisabled' => true],
    );

    if ($disabled) {
        $triggerAttributes = $triggerAttributes->merge(['disabled' => true]);
    }
@endphp

<button {{ $triggerAttributes }} data-date-picker-trigger>
    <span class="flex min-w-0 flex-1 items-center gap-2">
        <svg class="size-4 shrink-0 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="M8 2v4" />
            <path d="M16 2v4" />
            <rect width="18" height="18" x="3" y="4" rx="2" />
            <path d="M3 10h18" />
        </svg>
        <x-stencil::date-picker.selected :$placeholder />
    </span>
    @if ($clearable)
        <span
            class="inline-flex size-6 cursor-pointer items-center justify-center rounded-md text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800"
            data-date-picker-clear
            role="button"
            tabindex="-1"
            aria-label="{{ __('stencil::messages.date_picker_clear') }}"
        >
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
            </svg>
        </span>
    @endif
    <svg class="size-4 shrink-0 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m6 9 6 6 6-6" /></svg>
</button>
