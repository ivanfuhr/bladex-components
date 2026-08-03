@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $max = max(1, min(10, (int) ($state['max'] ?? 5)));
@endphp

<x-ui::rating name="score" :value="3" :max="$max" :invalid="$invalid" :disabled="$disabled" />
