@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $multiple = (bool) ($state['multiple'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $placeholder = (string) ($state['placeholder'] ?? 'Choose industry…');
    $display = ($state['display'] ?? 'count') === 'chips' ? 'chips' : 'count';
    $fieldName = $multiple ? 'industries' : 'industry';
@endphp

<x-stencil::select
    :name="$fieldName"
    :placeholder="$placeholder"
    :invalid="$invalid"
    :disabled="$disabled"
    :size="$size"
    :multiple="$multiple"
    :display="$display"
    class="w-full max-w-md"
>
    <x-stencil::select.group>
        <x-stencil::select.label>Creative</x-stencil::select.label>
        <x-stencil::select.item value="photo">Photography</x-stencil::select.item>
        <x-stencil::select.item value="design">Design services</x-stencil::select.item>
    </x-stencil::select.group>
    <x-stencil::select.separator />
    <x-stencil::select.item value="web">Web development</x-stencil::select.item>
    <x-stencil::select.item value="accounting">Accounting</x-stencil::select.item>
    <x-stencil::select.item value="other">Other</x-stencil::select.item>
</x-stencil::select>
