@php
    $side = $state['side'] ?? 'top';
@endphp

<div class="flex justify-center py-8">
    <x-ui::tooltip :side="$side">
        <x-ui::tooltip.trigger>
            <x-ui::button variant="outline">Hover me</x-ui::button>
        </x-ui::tooltip.trigger>
        <x-ui::tooltip.content>Add to library</x-ui::tooltip.content>
    </x-ui::tooltip>
</div>
