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
        <x-stencil::icon name="calendar" class="size-4 shrink-0 opacity-50" />
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
            <x-stencil::icon name="x" class="size-3.5" />
        </span>
    @endif
    <x-stencil::icon name="chevron-down" class="size-4 shrink-0 opacity-50" />
</button>
