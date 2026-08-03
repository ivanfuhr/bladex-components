@php
    $orientation = ($state['orientation'] ?? 'horizontal') === 'vertical' ? 'vertical' : null;
@endphp

@if ($orientation === 'vertical')
    <div class="flex h-8 items-center gap-3 text-sm">
        <span>Blog</span>
        <x-ui::separator orientation="vertical" :decorative="false" />
        <span>Docs</span>
        <x-ui::separator orientation="vertical" :decorative="false" />
        <span>Source</span>
    </div>
@else
    <div class="max-w-lg space-y-3">
        <x-ui::text size="sm">Account settings</x-ui::text>
        <x-ui::separator />
        <x-ui::text size="sm" variant="subtle">Manage your workspace preferences below.</x-ui::text>
    </div>
@endif
