@php
    $withSeconds = (bool) ($state['withSeconds'] ?? false);
    $clearable = (bool) ($state['clearable'] ?? true);
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $value = $withSeconds ? '09:15:00' : '09:15';
@endphp

<div class="w-full max-w-xs">
    <x-ui::time-picker
        name="playbook_time"
        :value="$value"
        :with-seconds="$withSeconds"
        :clearable="$clearable"
        :invalid="$invalid"
        :disabled="$disabled"
    />
</div>
