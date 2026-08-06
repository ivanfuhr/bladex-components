@php
    $mode = ($state['mode'] ?? 'single') === 'range' ? 'range' : 'single';
    $withToday = (bool) ($state['withToday'] ?? true);
    $weekNumbers = (bool) ($state['weekNumbers'] ?? false);
    $value = $mode === 'range' ? '2026-09-14/2026-09-18' : '2026-09-18';
@endphp

<x-std::calendar
    name="playbook_calendar"
    :value="$value"
    :mode="$mode"
    :with-today="$withToday"
    :week-numbers="$weekNumbers"
    class="w-fit"
/>
