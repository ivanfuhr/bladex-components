<div {{ $rootAttributes }}>
    @if ($shortcut)
        <x-std::scroll-area.viewport> {{ $slot }} </x-std::scroll-area.viewport>
        <x-std::scroll-area.scrollbar orientation="vertical" />
        @if ($horizontal)
            <x-std::scroll-area.scrollbar orientation="horizontal" />
            <x-std::scroll-area.corner />
        @endif
    @else
        {{ $slot }}
    @endif
</div>
