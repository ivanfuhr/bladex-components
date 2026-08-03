@php
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $checked = (bool) ($state['checked'] ?? false);
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
@endphp

<x-ui::field name="terms" orientation="inline" class="max-w-md">
    <x-ui::checkbox name="terms" :size="$size" :checked="$checked" :invalid="$invalid" :disabled="$disabled" />
    <div class="flex flex-col gap-1">
        <x-ui::field.label>Accept terms</x-ui::field.label>
        <x-ui::field.description>Required to continue.</x-ui::field.description>
    </div>
</x-ui::field>
