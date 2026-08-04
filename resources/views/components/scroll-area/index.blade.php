<div {{ $rootAttributes }}>
    @if ($shortcut)
        <x-ui::scroll-area.viewport> {{ $slot }} </x-ui::scroll-area.viewport>
        <x-ui::scroll-area.scrollbar orientation="vertical" />
        @if ($horizontal)
            <x-ui::scroll-area.scrollbar orientation="horizontal" />
            <x-ui::scroll-area.corner />
        @endif
    @else
        {{ $slot }}
    @endif
</div>
