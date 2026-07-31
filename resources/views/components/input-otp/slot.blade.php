@aware([
    'size' => null,
    'invalid' => false,
    'fieldInvalid' => false,
    'disabled' => false,
    'mode' => 'numeric',
    'length' => 6,
    'value' => null,
    'inputOtpId' => null,
    'name' => null,
    'controlId' => null,
])

@props([
    'index' => 0,
    'invalid' => false,
    'disabled' => false,
    'size' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $isInvalid = $invalid || $fieldInvalid;
    $index = max(0, (int) $index);
    $length = max(1, (int) $length);
    $mode = in_array($mode, ['numeric', 'alphanumeric'], true) ? $mode : 'numeric';

    $resolvedInputOtpId = filled($inputOtpId)
        ? $inputOtpId
        : (filled($name) ? $name : null);
    $resolvedControlId = filled($controlId) ? $controlId : $resolvedInputOtpId;

    $scalarValue = filled($value) ? (string) $value : '';
    $char = mb_substr($scalarValue, $index, 1);

    $slotId = filled($resolvedControlId)
        ? $resolvedControlId.($index === 0 ? '' : '-'.$index)
        : null;

    $ariaLabel = __('stencil::messages.input_otp_digit', [
        'position' => $index + 1,
        'length' => $length,
    ]);

    $slotClasses = collect([
        'input-otp__slot',
        'text-center font-medium tabular-nums !px-0',
        $size === 'sm' ? 'w-8' : 'w-9',
        $formControl->fieldSurfaceClasses($size, includeReadOnly: false, cursor: 'text'),
        $formControl->invalidFieldClasses(),
        $isInvalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
    ])->filter()->implode(' ');

    $inputAttributes = $interactionState->apply(
        $attributes
            ->except(['index', 'invalid', 'disabled', 'size'])
            ->class($slotClasses)
            ->merge([
                'type' => 'text',
                'inputmode' => $mode === 'numeric' ? 'numeric' : 'text',
                'autocomplete' => $index === 0 ? 'one-time-code' : 'off',
                'autocapitalize' => 'characters',
                'autocorrect' => 'off',
                'spellcheck' => 'false',
                'aria-label' => $ariaLabel,
                'data-input-otp-slot' => true,
                'data-index' => (string) $index,
                'value' => $char,
            ]),
        ['nativeDisabled' => true],
    );

    if ($mode === 'numeric') {
        $inputAttributes = $inputAttributes->merge(['pattern' => '[0-9]*']);
    }

    if ($isInvalid) {
        $inputAttributes = $inputAttributes->merge(['aria-invalid' => 'true']);
    }

    if ($disabled) {
        $inputAttributes = $inputAttributes->merge(['disabled' => true]);
    }

    if (filled($slotId)) {
        $inputAttributes = $inputAttributes->merge(['id' => $slotId]);
    }
@endphp

<input {{ $inputAttributes }} />
