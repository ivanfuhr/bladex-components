@php
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $checked = (bool) ($state['checked'] ?? false);
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
@endphp

<x-ui::field name="notifications" orientation="inline" class="max-w-md">
    <div class="flex flex-1 flex-col gap-1">
        <x-ui::field.label>Notifications</x-ui::field.label>
        <x-ui::field.description>Email alerts for account activity.</x-ui::field.description>
    </div>
    <x-ui::switch name="notifications" :size="$size" :checked="$checked" :invalid="$invalid" :disabled="$disabled" />
</x-ui::field>
