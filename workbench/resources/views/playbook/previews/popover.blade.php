@php
    $align = $state['align'] ?? 'start';
    $side = $state['side'] ?? 'bottom';
@endphp

<div class="flex justify-center py-8">
    <x-ui::popover :align="$align" :side="$side">
        <x-ui::popover.trigger>
            <x-ui::button variant="outline">Open popover</x-ui::button>
        </x-ui::popover.trigger>
        <x-ui::popover.content class="w-72">
            <div class="space-y-2">
                <x-ui::heading :level="3" class="text-sm!">Dimensions</x-ui::heading>
                <x-ui::text size="sm" variant="subtle"> Set the preferred width and height for this panel. </x-ui::text>
                <x-ui::button type="button" variant="secondary" size="sm" class="w-full" data-popover-close>
                    Done
                </x-ui::button>
            </div>
        </x-ui::popover.content>
    </x-ui::popover>
</div>
