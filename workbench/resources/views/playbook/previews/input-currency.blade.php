@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $readonly = (bool) ($state['readonly'] ?? false);
    $value = (float) ($state['value'] ?? 1234.56);
    $currency = (string) ($state['currency'] ?? 'BRL');
    $locale = (string) ($state['locale'] ?? 'pt_BR');
@endphp

<x-ui::input.currency
    name="amount"
    :value="$value"
    :currency="$currency"
    :locale="$locale"
    :precision="2"
    placeholder="0,00"
    :invalid="$invalid"
    :disabled="$disabled"
    :readonly="$readonly"
/>
