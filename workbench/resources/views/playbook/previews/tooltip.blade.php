@php
    $side = $state['side'] ?? 'top';
@endphp

<div class="flex justify-center py-8">
    <x-stencil::tooltip :side="$side">
        <x-stencil::tooltip.trigger>
            <x-stencil::button variant="outline">Hover me</x-stencil::button>
        </x-stencil::tooltip.trigger>
        <x-stencil::tooltip.content>Add to library</x-stencil::tooltip.content>
    </x-stencil::tooltip>
</div>
