<div {{ $rootAttributes }}>
    @if ($shortcut)
        <x-ui::command.input :placeholder="$placeholder" />
        <x-ui::command.list>
            <x-ui::command.empty>{{ $emptyMessage }}</x-ui::command.empty>
            {{ $slot }}
        </x-ui::command.list>
    @else
        {{ $slot }}
    @endif
</div>
