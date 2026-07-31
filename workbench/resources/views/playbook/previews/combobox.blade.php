@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $placeholder = (string) ($state['placeholder'] ?? 'Search frameworks…');
@endphp

<x-stencil::combobox
    name="framework"
    :placeholder="$placeholder"
    :invalid="$invalid"
    :disabled="$disabled"
    :size="$size"
    class="w-full max-w-md"
>
    <x-stencil::combobox.group>
        <x-stencil::combobox.label>PHP</x-stencil::combobox.label>
        <x-stencil::combobox.item value="laravel">Laravel</x-stencil::combobox.item>
        <x-stencil::combobox.item value="symfony">Symfony</x-stencil::combobox.item>
    </x-stencil::combobox.group>
    <x-stencil::combobox.separator />
    <x-stencil::combobox.group>
        <x-stencil::combobox.label>JavaScript</x-stencil::combobox.label>
        <x-stencil::combobox.item value="react">React</x-stencil::combobox.item>
        <x-stencil::combobox.item value="vue">Vue</x-stencil::combobox.item>
        <x-stencil::combobox.item value="svelte">Svelte</x-stencil::combobox.item>
    </x-stencil::combobox.group>
    <x-stencil::combobox.separator />
    <x-stencil::combobox.item value="rails">Ruby on Rails</x-stencil::combobox.item>
    <x-stencil::combobox.item value="django">Django</x-stencil::combobox.item>
</x-stencil::combobox>
