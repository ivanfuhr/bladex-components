<div {{ $scrollbarAttributes }}>
    @if ($slot->isEmpty())
        <x-std::scroll-area.thumb />
    @else
        {{ $slot }}
    @endif
</div>
