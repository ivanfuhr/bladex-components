@php
    $orientation = ($state['orientation'] ?? 'horizontal') === 'vertical' ? 'vertical' : 'horizontal';
    $showSeparator = (bool) ($state['show_separator'] ?? false);
    $showText = (bool) ($state['show_text'] ?? false);
@endphp

<div class="flex flex-col gap-4">
    <x-stencil::button-group :orientation="$orientation" aria-label="Document actions">
        @if ($showText)
            <x-stencil::button-group.text>Export</x-stencil::button-group.text>
        @endif
        <x-stencil::button variant="outline">Archive</x-stencil::button>
        @if ($showSeparator)
            <x-stencil::button-group.separator />
        @endif
        <x-stencil::button variant="outline">Report</x-stencil::button>
        <x-stencil::button variant="outline">Snooze</x-stencil::button>
    </x-stencil::button-group>
</div>
