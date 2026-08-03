@php
    $sizeClass = match ($state['size'] ?? 'outline') {
        'micro' => 'size-3',
        'mini' => 'size-5',
        default => 'size-4',
    };

    $icons = ['check', 'plus', 'eye', 'calendar', 'clock', 'upload', 'copy', 'star', 'file', 'x'];
@endphp

<div class="grid max-w-md grid-cols-5 gap-4">
    @foreach ($icons as $icon)
        <div class="flex flex-col items-center gap-2 text-center">
            <x-ui::icon :name="$icon" class="{{ $sizeClass }}" />
            <x-ui::text size="sm" variant="subtle">{{ $icon }}</x-ui::text>
        </div>
    @endforeach
</div>
