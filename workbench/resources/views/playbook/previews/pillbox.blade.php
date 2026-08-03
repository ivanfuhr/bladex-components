@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $max = filled($state['max'] ?? null) ? max(1, (int) $state['max']) : null;
    $value = ['laravel', 'php', 'blade'];
@endphp

<x-ui::pillbox
    name="tags"
    :value="$value"
    :max="$max"
    :invalid="$invalid"
    :disabled="$disabled"
    placeholder="Add tags…"
    class="w-full max-w-xl"
/>
