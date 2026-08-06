@php
    $mode = ($state['mode'] ?? 'single') === 'range' ? 'range' : 'single';
    $withPresets = (bool) ($state['withPresets'] ?? false);
    $withToday = (bool) ($state['withToday'] ?? true);
@endphp

<x-std::date-picker
    name="playbook_date"
    value="2026-07-29"
    :mode="$mode"
    :with-presets="$withPresets"
    :with-today="$withToday"
/>
