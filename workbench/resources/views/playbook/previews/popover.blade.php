@php
    $align = $state['align'] ?? 'start';
    $side = $state['side'] ?? 'bottom';
@endphp

<div class="flex justify-center py-8">
    <x-std::popover :align="$align" :side="$side">
        <x-std::popover.trigger>
            <x-std::button variant="outline">Open popover</x-std::button>
        </x-std::popover.trigger>
        <x-std::popover.content class="w-72">
            <div class="space-y-2">
                <x-std::heading :level="3" class="text-sm!">Dimensions</x-std::heading>
                <x-std::text size="sm" variant="subtle">
                    Set the preferred width and height for this panel.
                </x-std::text>
                <x-std::button type="button" variant="secondary" size="sm" class="w-full" data-popover-close>
                    Done
                </x-std::button>
            </div>
        </x-std::popover.content>
    </x-std::popover>
</div>
