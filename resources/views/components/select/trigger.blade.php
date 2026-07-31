@aware([
    'size' => null,
    'invalid' => false,
    'disabled' => false,
    'selectId' => null,
    'listboxId' => null,
    'multiple' => false,
    'display' => 'count',
    'controlId' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $chipsLayout = $multiple && $display === 'chips';

    $triggerAttributes = $interactionState->apply(
        $attributes
            ->class([
                'select__trigger',
                'group flex w-full min-w-0 items-center justify-between gap-2 text-left',
                $chipsLayout ? 'h-auto min-h-9 py-1.5' : null,
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

    $triggerId = filled($controlId) ? $controlId : (filled($selectId) ? $selectId : null);

    if (filled($triggerId)) {
        $triggerAttributes = $triggerAttributes->merge(['id' => $triggerId]);
    }

    if (filled($listboxId)) {
        $triggerAttributes = $triggerAttributes->merge(['aria-controls' => $listboxId]);
    }

    $chevronClasses = $size === 'sm' ? 'size-3.5 shrink-0 opacity-50' : 'size-4 shrink-0 opacity-50';
@endphp

<button {{ $triggerAttributes }} data-select-trigger>
    <span @class([
        'select__trigger-inner flex min-w-0 flex-1 gap-2',
        'flex-wrap items-center' => $chipsLayout,
        'items-center' => ! $chipsLayout,
    ])>
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
