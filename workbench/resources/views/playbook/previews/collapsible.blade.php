@php
    $open = (bool) ($state['open'] ?? true);
    $transition = (bool) ($state['transition'] ?? true);
@endphp

<div class="max-w-md rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">
    <x-ui::collapsible :open="$open" :transition="$transition">
        <x-ui::collapsible.trigger>Toggle details</x-ui::collapsible.trigger>
        <x-ui::collapsible.content class="mt-2">
            Extra product information lives here — dimensions, materials, and care instructions.
        </x-ui::collapsible.content>
    </x-ui::collapsible>
</div>
