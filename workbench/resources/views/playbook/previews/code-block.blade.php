@php
    $language = (string) ($state['language'] ?? 'blade');
    $showCopy = (bool) ($state['show_copy'] ?? true);
    $sample = <<<'BLADE'
    <x-std::button-group aria-label="Document actions">
        <x-std::button variant="outline">Archive</x-std::button>
        <x-std::button variant="outline">Report</x-std::button>
        <x-std::button variant="outline">Snooze</x-std::button>
    </x-std::button-group>
    BLADE;
@endphp

<div class="w-full max-w-2xl">
    <x-std::code-block :language="$language" :code="$sample" :copyable="$showCopy" />
</div>
