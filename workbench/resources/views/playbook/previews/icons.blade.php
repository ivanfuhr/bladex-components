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
            <x-stencil::icon :name="$icon" class="{{ $sizeClass }}" />
            <x-stencil::text size="sm" variant="subtle">{{ $icon }}</x-stencil::text>
        </div>
    @endforeach
</div>
