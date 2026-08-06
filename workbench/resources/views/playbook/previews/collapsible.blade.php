@php
    $open = (bool) ($state['open'] ?? true);
    $transition = (bool) ($state['transition'] ?? true);
@endphp

<div class="max-w-md rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">
    <x-std::collapsible :open="$open" :transition="$transition">
        <x-std::collapsible.trigger>Toggle details</x-std::collapsible.trigger>
        <x-std::collapsible.content class="mt-2">
            Extra product information lives here — dimensions, materials, and care instructions.
        </x-std::collapsible.content>
    </x-std::collapsible>
</div>
