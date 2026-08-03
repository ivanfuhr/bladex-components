@php
    $orientation = ($state['orientation'] ?? 'horizontal') === 'vertical' ? 'vertical' : 'horizontal';
    $showSeparator = (bool) ($state['show_separator'] ?? false);
    $showText = (bool) ($state['show_text'] ?? false);
@endphp

<div class="flex flex-col gap-4">
    <x-ui::button-group :orientation="$orientation" aria-label="Document actions">
        @if ($showText)
            <x-ui::button-group.text>Export</x-ui::button-group.text>
        @endif
        <x-ui::button variant="outline">Archive</x-ui::button>
        @if ($showSeparator)
            <x-ui::button-group.separator />
        @endif
        <x-ui::button variant="outline">Report</x-ui::button>
        <x-ui::button variant="outline">Snooze</x-ui::button>
    </x-ui::button-group>
</div>
