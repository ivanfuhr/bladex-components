@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $multiple = (bool) ($state['multiple'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $placeholder = (string) ($state['placeholder'] ?? 'Choose industry…');
    $display = ($state['display'] ?? 'count') === 'chips' ? 'chips' : 'count';
    $fieldName = $multiple ? 'industries' : 'industry';
@endphp

<x-std::select
    :name="$fieldName"
    :placeholder="$placeholder"
    :invalid="$invalid"
    :disabled="$disabled"
    :size="$size"
    :multiple="$multiple"
    :display="$display"
    class="w-full max-w-md"
>
    <x-std::select.group>
        <x-std::select.label>Creative</x-std::select.label>
        <x-std::select.item value="photo">Photography</x-std::select.item>
        <x-std::select.item value="design">Design services</x-std::select.item>
    </x-std::select.group>
    <x-std::select.separator />
    <x-std::select.item value="web">Web development</x-std::select.item>
    <x-std::select.item value="accounting">Accounting</x-std::select.item>
    <x-std::select.item value="other">Other</x-std::select.item>
</x-std::select>
