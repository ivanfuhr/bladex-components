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
