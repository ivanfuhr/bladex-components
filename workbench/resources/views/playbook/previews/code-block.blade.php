@php
    $language = (string) ($state['language'] ?? 'blade');
    $showCopy = (bool) ($state['show_copy'] ?? true);
    $sample = <<<'BLADE'
<x-ui::button-group aria-label="Document actions">
    <x-ui::button variant="outline">Archive</x-ui::button>
    <x-ui::button variant="outline">Report</x-ui::button>
    <x-ui::button variant="outline">Snooze</x-ui::button>
</x-ui::button-group>
BLADE;
@endphp

<div class="w-full max-w-2xl">
    <x-ui::code-block
        :language="$language"
        :code="$sample"
        :copyable="$showCopy"
    />
</div>
