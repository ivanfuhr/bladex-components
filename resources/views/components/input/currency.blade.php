@props([
    'name' => null,
    'value' => null,
    'currency' => null,
    'locale' => null,
    'precision' => null,
    'mode' => 'cents',
    'invalid' => false,
    'size' => null,
])

@aware([
    'fieldInvalid' => false,
])

@php
    use Illuminate\Support\Number;
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $invalid = $invalid || $fieldInvalid;

    $currencyCode = filled($currency) ? (string) $currency : Number::defaultCurrency();
    $localeCode = filled($locale) ? (string) $locale : Number::defaultLocale();

    if (! filled($localeCode)) {
        $localeCode = str_replace('-', '_', (string) app()->getLocale());
    }

    $fractionDigits = $precision ?? 2;
    $fractionDigits = max(0, (int) $fractionDigits);

    $mode = in_array($mode, ['cents', 'decimal'], true) ? $mode : 'cents';

    $numericValue = null;

    if ($value !== null && $value !== '') {
        if (is_numeric($value)) {
            $numericValue = (float) $value;
        }
    }

    $displayValue = $numericValue !== null
        ? Number::currency($numericValue, $currencyCode, $localeCode, $precision)
        : '';

    $hiddenValue = $numericValue !== null
        ? number_format($numericValue, $fractionDigits, '.', '')
        : '';

    $localeForJs = str_replace('_', '-', $localeCode);

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $userClass = $attributes->get('class');
    $applyFullWidth = ! filled($userClass);

    $controlClasses = collect([
        'input__control',
        'input-currency__control',
        'flex w-full min-w-0',
        $formControl->fieldSurfaceClasses($size),
        'placeholder:text-zinc-500 dark:placeholder:text-zinc-400',
        $formControl->invalidFieldClasses(),
        $invalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
    ])->filter()->implode(' ');

    $wrapperClasses = collect([
        'input',
        'input-currency',
        'relative flex min-w-0 items-stretch overflow-visible',
        $applyFullWidth ? 'w-full' : null,
        $userClass,
    ])->filter()->implode(' ');

    $controlExtraClass = $attributes->get('class:input') ?? $attributes->get('input:class');

    $controlAttributes = $interactionState->apply(
        $attributes
            ->except(['class', 'class:input', 'input:class', 'name', 'value', 'currency', 'locale', 'precision', 'mode'])
            ->class([$controlClasses, $controlExtraClass])
            ->merge([
                'type' => 'text',
                'inputmode' => 'numeric',
                'autocomplete' => 'off',
                'value' => $displayValue,
                'data-input-control' => true,
                'data-input-currency-display' => true,
            ]),
    );

    if ($invalid) {
        $controlAttributes = $controlAttributes->merge(['aria-invalid' => 'true']);
    }

@endphp

<div
    @class([$wrapperClasses])
    data-input
    data-input-currency
    data-input-currency-mode="{{ $mode }}"
    data-input-currency-locale="{{ $localeForJs }}"
    data-input-currency-currency="{{ $currencyCode }}"
    data-input-currency-precision="{{ $fractionDigits }}"
>
    <input
        type="hidden"
        data-input-currency-value
        @if (filled($name)) name="{{ $name }}" @endif
        @if ($hiddenValue !== '') value="{{ $hiddenValue }}" @endif
    />

    <input {{ $controlAttributes }} />
</div>
