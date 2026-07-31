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
                'time-picker__trigger',
                'group flex w-full min-w-0 items-center justify-between gap-2 text-left',
                $formControl->fieldSurfaceClasses($size, includeReadOnly: false, cursor: 'pointer'),
                $invalid ? 'border-red-500' : null,
            ])
            ->merge([
                'type' => 'button',
                'aria-haspopup' => 'listbox',
                'aria-expanded' => 'false',
            ]),
        ['nativeDisabled' => true],
    );
@endphp

<button {{ $triggerAttributes }} data-time-picker-trigger>
    <x-stencil::time-picker.selected :$placeholder />
    <x-stencil::icon name="chevron-down" class="size-4 shrink-0 opacity-50" />
</button>
