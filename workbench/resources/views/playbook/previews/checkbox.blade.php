@php
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $checked = (bool) ($state['checked'] ?? false);
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
@endphp

<x-std::field name="terms" orientation="inline" class="max-w-md">
    <x-std::checkbox name="terms" :size="$size" :checked="$checked" :invalid="$invalid" :disabled="$disabled" />
    <div class="flex flex-col gap-1">
        <x-std::field.label>Accept terms</x-std::field.label>
        <x-std::field.description>Required to continue.</x-std::field.description>
    </div>
</x-std::field>
