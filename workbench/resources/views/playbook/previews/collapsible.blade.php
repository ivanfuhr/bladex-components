@php
    $open = (bool) ($state['open'] ?? true);
    $transition = (bool) ($state['transition'] ?? true);
@endphp

<div class="max-w-md rounded-xl border border-zinc-200 p-4 dark:border-zinc-800">
    <x-stencil::collapsible :open="$open" :transition="$transition">
        <x-stencil::collapsible.trigger>Toggle details</x-stencil::collapsible.trigger>
        <x-stencil::collapsible.content class="mt-2">
            Extra product information lives here — dimensions, materials, and care instructions.
        </x-stencil::collapsible.content>
    </x-stencil::collapsible>
</div>
