@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $placeholder = (string) ($state['placeholder'] ?? 'Choose industry…');
@endphp

<x-bladex-components::select
    name="industry"
    :placeholder="$placeholder"
    :invalid="$invalid"
    :disabled="$disabled"
    :size="$size"
    class="max-w-md w-full"
>
    <x-bladex-components::select.group>
        <x-bladex-components::select.label>Creative</x-bladex-components::select.label>
        <x-bladex-components::select.item value="photo">Photography</x-bladex-components::select.item>
        <x-bladex-components::select.item value="design">Design services</x-bladex-components::select.item>
    </x-bladex-components::select.group>
    <x-bladex-components::select.separator />
    <x-bladex-components::select.item value="web">Web development</x-bladex-components::select.item>
    <x-bladex-components::select.item value="accounting">Accounting</x-bladex-components::select.item>
    <x-bladex-components::select.item value="other">Other</x-bladex-components::select.item>
</x-bladex-components::select>
