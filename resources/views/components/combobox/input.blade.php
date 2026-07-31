@aware([
    'size' => null,
    'invalid' => false,
    'fieldInvalid' => false,
    'disabled' => false,
    'placeholder' => null,
    'name' => null,
    'comboboxId' => null,
    'listboxId' => null,
    'controlId' => null,
])

@props([
    'placeholder' => null,
    'invalid' => false,
    'disabled' => false,
    'size' => null,
    'comboboxId' => null,
    'listboxId' => null,
    'controlId' => null,
    'multiple' => false,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $isInvalid = $invalid || $fieldInvalid;
    $resolvedPlaceholder = filled($placeholder) ? $placeholder : null;

    $resolvedComboboxId = filled($comboboxId)
        ? $comboboxId
        : (filled($name) ? $name : null);
    $resolvedListboxId = filled($listboxId)
        ? $listboxId
        : (filled($resolvedComboboxId) ? $resolvedComboboxId.'-listbox' : null);
    $resolvedControlId = filled($controlId) ? $controlId : $resolvedComboboxId;

    $inputAttributes = $interactionState->apply(
        $attributes
            ->except(['placeholder', 'invalid', 'disabled', 'size', 'comboboxId', 'listboxId', 'controlId'])
            ->class([
                'combobox__input',
                'group flex w-full min-w-0 !pr-9',
                $formControl->fieldSurfaceClasses($size, includeReadOnly: false, cursor: 'text'),
                'placeholder:text-zinc-500 dark:placeholder:text-zinc-400',
                $formControl->invalidFieldClasses(),
                'aria-expanded:border-zinc-300 aria-expanded:ring-2 aria-expanded:ring-zinc-950/10',
                'dark:aria-expanded:border-zinc-600 dark:aria-expanded:ring-zinc-300/20',
                $isInvalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
            ])
            ->merge([
                'type' => 'text',
                'role' => 'combobox',
                'aria-autocomplete' => 'list',
                'aria-expanded' => 'false',
                'aria-haspopup' => 'listbox',
                'autocomplete' => 'off',
                'spellcheck' => 'false',
            ]),
        ['nativeDisabled' => true],
    );

    if ($isInvalid) {
        $inputAttributes = $inputAttributes->merge(['aria-invalid' => 'true']);
    }

    if ($disabled) {
        $inputAttributes = $inputAttributes->merge(['disabled' => true]);
    }

    if (filled($resolvedPlaceholder)) {
        $inputAttributes = $inputAttributes->merge(['placeholder' => $resolvedPlaceholder]);
    }

    if (filled($resolvedControlId)) {
        $inputAttributes = $inputAttributes->merge(['id' => $resolvedControlId]);
    }

    if (filled($resolvedListboxId)) {
        $inputAttributes = $inputAttributes->merge(['aria-controls' => $resolvedListboxId]);
    }

    $chevronClasses = $size === 'sm' ? 'size-3.5 shrink-0 opacity-50' : 'size-4 shrink-0 opacity-50';
@endphp

<div class="combobox__input-wrap relative flex w-full min-w-0 items-stretch" data-combobox-input-wrap>
    @if ($multiple)
        @if ($slot->isEmpty())
            <span
                class="combobox__value shrink-0 text-sm text-zinc-500 dark:text-zinc-400"
                data-combobox-value
                data-placeholder="{{ $resolvedPlaceholder }}"
            ></span>
        @else
            {{ $slot }}
        @endif
        <input
            {{ $inputAttributes->except(['id', 'role', 'aria-autocomplete', 'aria-expanded', 'aria-haspopup', 'aria-controls', 'autocomplete', 'spellcheck']) }}
            class="combobox__input combobox__input--multiple min-w-[6rem] flex-1 border-0 bg-transparent p-0 text-sm shadow-none focus-visible:ring-0"
            data-combobox-filter-input
            @if ($resolvedPlaceholder) placeholder="{{ $resolvedPlaceholder }}" @endif
        />
    @else
        <input {{ $inputAttributes }} data-combobox-input />
    @endif
    <button
        type="button"
        class="combobox__toggle absolute inset-y-0 right-0 z-10 flex w-9 items-center justify-center text-zinc-500 disabled:cursor-not-allowed disabled:opacity-50 dark:text-zinc-400"
        data-combobox-toggle
        tabindex="-1"
        aria-label="{{ __('stencil::messages.combobox_toggle') }}"
        aria-expanded="false"
        @if (filled($resolvedListboxId)) aria-controls="{{ $resolvedListboxId }}" @endif
        @if ($disabled) disabled @endif
    >
        <x-stencil::icon
            name="chevron-down"
            class="{{ $chevronClasses }} text-zinc-500 transition-transform duration-200 dark:text-zinc-400"
            data-combobox-chevron
        />
    </button>
</div>
