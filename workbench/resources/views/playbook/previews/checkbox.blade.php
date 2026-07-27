@php
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $checked = (bool) ($state['checked'] ?? false);
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
@endphp

<x-stencil::field name="terms" orientation="inline" class="max-w-md">
    <x-stencil::checkbox name="terms" :size="$size" :checked="$checked" :invalid="$invalid" :disabled="$disabled" />
    <div class="flex flex-col gap-1">
        <x-stencil::field.label>Accept terms</x-stencil::field.label>
        <x-stencil::field.description>Required to continue.</x-stencil::field.description>
    </div>
</x-stencil::field>
