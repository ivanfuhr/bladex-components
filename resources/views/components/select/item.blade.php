<div {{ $itemAttributes }}>
    <span class="min-w-0 flex-1 truncate" data-select-item-label>{{ $slot }}</span>
    <x-std::icon
        name="check"
        class="pointer-events-none absolute top-1/2 right-2 size-4 -translate-y-1/2 text-zinc-900 opacity-0 dark:text-zinc-50"
        data-select-item-check
    />
</div>
