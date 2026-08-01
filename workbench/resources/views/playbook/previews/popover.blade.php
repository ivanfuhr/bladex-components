@php
    $align = $state['align'] ?? 'start';
    $side = $state['side'] ?? 'bottom';
@endphp

<div class="flex justify-center py-8">
    <x-stencil::popover :align="$align" :side="$side">
        <x-stencil::popover.trigger>
            <x-stencil::button variant="outline">Open popover</x-stencil::button>
        </x-stencil::popover.trigger>
        <x-stencil::popover.content class="w-72">
            <div class="space-y-2">
                <x-stencil::heading :level="3" class="text-sm!">Dimensions</x-stencil::heading>
                <x-stencil::text size="sm" variant="subtle">
                    Set the preferred width and height for this panel.
                </x-stencil::text>
                <x-stencil::button type="button" variant="secondary" size="sm" class="w-full" data-popover-close>
                    Done
                </x-stencil::button>
            </div>
        </x-stencil::popover.content>
    </x-stencil::popover>
</div>
