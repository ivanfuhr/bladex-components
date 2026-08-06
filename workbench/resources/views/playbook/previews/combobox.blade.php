@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $placeholder = (string) ($state['placeholder'] ?? 'Search frameworks…');
@endphp

<x-std::combobox
    name="framework"
    :placeholder="$placeholder"
    :invalid="$invalid"
    :disabled="$disabled"
    :size="$size"
    class="w-full max-w-md"
>
    <x-std::combobox.group>
        <x-std::combobox.label>PHP</x-std::combobox.label>
        <x-std::combobox.item value="laravel">Laravel</x-std::combobox.item>
        <x-std::combobox.item value="symfony">Symfony</x-std::combobox.item>
    </x-std::combobox.group>
    <x-std::combobox.separator />
    <x-std::combobox.group>
        <x-std::combobox.label>JavaScript</x-std::combobox.label>
        <x-std::combobox.item value="react">React</x-std::combobox.item>
        <x-std::combobox.item value="vue">Vue</x-std::combobox.item>
        <x-std::combobox.item value="svelte">Svelte</x-std::combobox.item>
    </x-std::combobox.group>
    <x-std::combobox.separator />
    <x-std::combobox.item value="rails">Ruby on Rails</x-std::combobox.item>
    <x-std::combobox.item value="django">Django</x-std::combobox.item>
</x-std::combobox>
