@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $placeholder = (string) ($state['placeholder'] ?? 'Search frameworks…');
@endphp

<x-ui::combobox
    name="framework"
    :placeholder="$placeholder"
    :invalid="$invalid"
    :disabled="$disabled"
    :size="$size"
    class="w-full max-w-md"
>
    <x-ui::combobox.group>
        <x-ui::combobox.label>PHP</x-ui::combobox.label>
        <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
        <x-ui::combobox.item value="symfony">Symfony</x-ui::combobox.item>
    </x-ui::combobox.group>
    <x-ui::combobox.separator />
    <x-ui::combobox.group>
        <x-ui::combobox.label>JavaScript</x-ui::combobox.label>
        <x-ui::combobox.item value="react">React</x-ui::combobox.item>
        <x-ui::combobox.item value="vue">Vue</x-ui::combobox.item>
        <x-ui::combobox.item value="svelte">Svelte</x-ui::combobox.item>
    </x-ui::combobox.group>
    <x-ui::combobox.separator />
    <x-ui::combobox.item value="rails">Ruby on Rails</x-ui::combobox.item>
    <x-ui::combobox.item value="django">Django</x-ui::combobox.item>
</x-ui::combobox>
