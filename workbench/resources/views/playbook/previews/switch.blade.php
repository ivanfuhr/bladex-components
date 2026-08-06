@php
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $checked = (bool) ($state['checked'] ?? false);
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
@endphp

<x-std::field name="notifications" orientation="inline" class="max-w-md">
    <div class="flex flex-1 flex-col gap-1">
        <x-std::field.label>Notifications</x-std::field.label>
        <x-std::field.description>Email alerts for account activity.</x-std::field.description>
    </div>
    <x-std::switch name="notifications" :size="$size" :checked="$checked" :invalid="$invalid" :disabled="$disabled" />
</x-std::field>
