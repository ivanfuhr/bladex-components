<div {{ $rootAttributes }}>
    @if ($shortcut)
        <x-std::command.input :placeholder="$placeholder" />
        <x-std::command.list>
            <x-std::command.empty>{{ $emptyMessage }}</x-std::command.empty>
            {{ $slot }}
        </x-std::command.list>
    @else
        {{ $slot }}
    @endif
</div>
