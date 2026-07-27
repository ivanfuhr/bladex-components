@props([
    'name' => null,
    'value' => '1',
    'checked' => false,
    'invalid' => false,
    'size' => null,
])

@aware([
    'fieldInvalid' => false,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $isInvalid = $invalid || $fieldInvalid;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $controlClasses = collect([
        $formControl->choiceControlClasses('checkbox', $size),
        'appearance-none grid place-content-center text-transparent',
        'checked:border-zinc-900 checked:bg-zinc-900 checked:text-white',
        'dark:checked:border-zinc-50 dark:checked:bg-zinc-50 dark:checked:text-zinc-900',
        'checked:bg-[length:75%_75%]',
        'checked:bg-center checked:bg-no-repeat',
        "checked:bg-[url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='white'%3E%3Cpath d='M12.207 4.793a1 1 0 0 1 0 1.414l-5 5a1 1 0 0 1-1.414 0l-2.5-2.5a1 1 0 0 1 1.414-1.414L6.5 9.086l4.293-4.293a1 1 0 0 1 1.414 0z'/%3E%3C/svg%3E\")]",
        "dark:checked:bg-[url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%2318181b'%3E%3Cpath d='M12.207 4.793a1 1 0 0 1 0 1.414l-5 5a1 1 0 0 1-1.414 0l-2.5-2.5a1 1 0 0 1 1.414-1.414L6.5 9.086l4.293-4.293a1 1 0 0 1 1.414 0z'/%3E%3C/svg%3E\")]",
    ])->implode(' ');

    $controlAttributes = $interactionState->apply(
        $attributes
            ->class($controlClasses)
            ->merge([
                'type' => 'checkbox',
                'data-checkbox-control' => true,
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
@endphp

<div class="checkbox inline-flex items-center" data-checkbox>
    <input {{ $controlAttributes }} />
</div>
