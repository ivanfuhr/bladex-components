@php
    $withToday = (bool) ($state['withToday'] ?? true);
    $clearable = (bool) ($state['clearable'] ?? false);
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
@endphp

<div class="w-full max-w-sm">
    <x-std::datetime-picker
        name="playbook_datetime"
        value="2026-09-18T09:15"
        :with-today="$withToday"
        :clearable="$clearable"
        :invalid="$invalid"
        :disabled="$disabled"
    />
</div>
