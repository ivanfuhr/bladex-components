@aware([
    'size' => null,
    'invalid' => false,
    'disabled' => false,
    'selectId' => null,
    'listboxId' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $triggerAttributes = $interactionState->apply(
        $attributes
            ->class([
                'select__trigger',
                'group flex w-full min-w-0 items-center justify-between gap-2 text-left',
                $formControl->fieldSurfaceClasses($size, includeReadOnly: false, cursor: 'pointer'),
                $formControl->invalidFieldClasses(),
                'aria-expanded:border-zinc-300 aria-expanded:ring-2 aria-expanded:ring-zinc-950/10',
                'dark:aria-expanded:border-zinc-600 dark:aria-expanded:ring-zinc-300/20',
                $invalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
            ])
            ->merge([
                'type' => 'button',
                'aria-haspopup' => 'listbox',
                'aria-expanded' => 'false',
            ]),
        ['nativeDisabled' => true],
    );

    if ($invalid) {
        $triggerAttributes = $triggerAttributes->merge(['aria-invalid' => 'true']);
    }

    if ($disabled) {
        $triggerAttributes = $triggerAttributes->merge(['disabled' => true]);
    }

    if (filled($selectId)) {
        $triggerAttributes = $triggerAttributes->merge(['id' => $selectId.'-trigger']);
    }

    if (filled($listboxId)) {
        $triggerAttributes = $triggerAttributes->merge(['aria-controls' => $listboxId]);
    }

    $chevronClasses = $size === 'sm' ? 'size-3.5 shrink-0 opacity-50' : 'size-4 shrink-0 opacity-50';
@endphp

<button {{ $triggerAttributes }} data-select-trigger>
    <span class="select__trigger-inner flex min-w-0 flex-1 items-center gap-2">
        {{ $slot }}
    </span>
    <svg
        class="{{ $chevronClasses }} text-zinc-500 transition-transform duration-200 group-aria-expanded:rotate-180 dark:text-zinc-400"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        aria-hidden="true"
        data-select-chevron
    >
        <path d="m6 9 6 6 6-6" />
    </svg>
</button>
