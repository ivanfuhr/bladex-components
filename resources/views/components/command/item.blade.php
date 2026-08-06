<{{ $tag }} {{ $itemAttributes }}>
    @if (filled($icon))
        <x-std::icon :name="$icon" class="size-4 shrink-0 text-zinc-500 dark:text-zinc-400" />
    @endif
    <span class="min-w-0 flex-1 truncate text-left" data-command-item-label>{{ $slot }}</span>
    @if (filled($kbd))
        <x-std::command.shortcut>{{ $kbd }}</x-std::command.shortcut>
    @endif
</{{ $tag }}>
