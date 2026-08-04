<div {{ $scrollbarAttributes }}>
    @if ($slot->isEmpty())
        <x-ui::scroll-area.thumb />
    @else
        {{ $slot }}
    @endif
</div>
