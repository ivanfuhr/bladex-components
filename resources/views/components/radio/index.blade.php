@props([
    'value' => null,
    'checked' => false,
    'invalid' => false,
    'size' => null,
    'label' => null,
])

@aware([
    'name' => null,
    'fieldInvalid' => false,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $isInvalid = $invalid || $fieldInvalid;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $controlId = $attributes->get('id') ?? 'radio-'.str_replace('.', '', uniqid('', true));

    $controlClasses = collect([
        $formControl->choiceControlClasses('radio', $size),
        'appearance-none',
        $size === 'sm' ? 'checked:border-[4px]' : 'checked:border-[5px]',
        'checked:border-zinc-900 checked:bg-white',
        'dark:checked:border-zinc-50 dark:checked:bg-zinc-950',
    ])->implode(' ');

    $controlAttributes = $interactionState->apply(
        $attributes
            ->except('id')
            ->class($controlClasses)
            ->merge([
                'type' => 'radio',
                'id' => $controlId,
                'data-radio-control' => true,
            ]),
        ['nativeDisabled' => true],
    );

    if (filled($name)) {
        $controlAttributes = $controlAttributes->merge(['name' => $name]);
    }

    if (filled($value)) {
        $controlAttributes = $controlAttributes->merge(['value' => $value]);
    }

    if ($checked) {
        $controlAttributes = $controlAttributes->merge(['checked' => true]);
    }

    if ($isInvalid) {
        $controlAttributes = $controlAttributes->merge(['aria-invalid' => 'true']);
    }

    $hasSlotLabel = ! $slot->isEmpty();
@endphp

<div class="radio flex items-start gap-2" data-radio>
    <input {{ $controlAttributes }} />

    @if ($hasSlotLabel)
        <x-stencil::label :for="$controlId" class="!font-normal">
            {{ $slot }}
        </x-stencil::label>
    @elseif (filled($label))
        <x-stencil::label :for="$controlId" class="!font-normal">
            {{ $label }}
        </x-stencil::label>
    @endif
</div>
