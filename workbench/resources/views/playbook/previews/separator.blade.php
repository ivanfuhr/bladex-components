@php
    $orientation = ($state['orientation'] ?? 'horizontal') === 'vertical' ? 'vertical' : null;
@endphp

@if ($orientation === 'vertical')
    <div class="flex h-8 items-center gap-3 text-sm">
        <span>Blog</span>
        <x-std::separator orientation="vertical" :decorative="false" />
        <span>Docs</span>
        <x-std::separator orientation="vertical" :decorative="false" />
        <span>Source</span>
    </div>
@else
    <div class="max-w-lg space-y-3">
        <x-std::text size="sm">Account settings</x-std::text>
        <x-std::separator />
        <x-std::text size="sm" variant="subtle">Manage your workspace preferences below.</x-std::text>
    </div>
@endif
