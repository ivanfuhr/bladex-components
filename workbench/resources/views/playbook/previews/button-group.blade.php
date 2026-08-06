@php
    $orientation = ($state['orientation'] ?? 'horizontal') === 'vertical' ? 'vertical' : 'horizontal';
    $showSeparator = (bool) ($state['show_separator'] ?? false);
    $showText = (bool) ($state['show_text'] ?? false);
@endphp

<div class="flex flex-col gap-4">
    <x-std::button-group :orientation="$orientation" aria-label="Document actions">
        @if ($showText)
            <x-std::button-group.text>Export</x-std::button-group.text>
        @endif
        <x-std::button variant="outline">Archive</x-std::button>
        @if ($showSeparator)
            <x-std::button-group.separator />
        @endif
        <x-std::button variant="outline">Report</x-std::button>
        <x-std::button variant="outline">Snooze</x-std::button>
    </x-std::button-group>
</div>
