@php
    $side = $state['side'] ?? 'top';
@endphp

<div class="flex justify-center py-8">
    <x-std::tooltip :side="$side">
        <x-std::tooltip.trigger>
            <x-std::button variant="outline">Hover me</x-std::button>
        </x-std::tooltip.trigger>
        <x-std::tooltip.content>Add to library</x-std::tooltip.content>
    </x-std::tooltip>
</div>
