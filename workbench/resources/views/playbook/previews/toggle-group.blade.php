@php
    $type = ($state['type'] ?? 'single') === 'multiple' ? 'multiple' : 'single';
    $variant = ($state['variant'] ?? 'outline') === 'default' ? 'default' : 'outline';
    $size = ($state['size'] ?? 'default') === 'default' ? null : (string) $state['size'];
    $orientation = ($state['orientation'] ?? 'horizontal') === 'vertical' ? 'vertical' : 'horizontal';
    $spacing = (int) ($state['spacing'] ?? 0);
    $defaultValue = $type === 'multiple' ? ['bold', 'italic'] : 'bold';
@endphp

<x-ui::toggle-group
    :type="$type"
    :variant="$variant"
    :size="$size"
    :orientation="$orientation"
    :spacing="$spacing"
    :default-value="$defaultValue"
    aria-label="Text formatting"
>
    <x-ui::toggle-group.item value="bold">Bold</x-ui::toggle-group.item>
    <x-ui::toggle-group.item value="italic">Italic</x-ui::toggle-group.item>
    <x-ui::toggle-group.item value="underline">Underline</x-ui::toggle-group.item>
</x-ui::toggle-group>
