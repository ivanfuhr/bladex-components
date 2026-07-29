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
    <svg class="size-4 shrink-0 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
</button>
