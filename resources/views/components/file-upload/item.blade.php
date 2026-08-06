<li {{ $itemAttributes }}>
    <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
        <x-std::icon name="file" class="size-4" data-file-upload-item-icon />
    </span>

    <span class="flex min-w-0 flex-1 flex-col gap-0.5">
        <span
            class="truncate text-sm font-semibold text-zinc-950 dark:text-zinc-50"
            data-file-upload-item-heading
        >{{ $resolvedHeading }}</span>

        <span
            class="truncate text-sm text-zinc-500 dark:text-zinc-400"
            data-file-upload-item-text
            @if (! filled($resolvedText)) hidden @endif
        >{{ $resolvedText }}</span>
    </span>

    <span class="flex shrink-0 items-center gap-1" data-file-upload-item-actions>
        @if (isset($actions) && ! $actions->isEmpty())
            {{ $actions }}
        @else
            <x-std::file-upload.item.remove :disabled="$disabled" />
        @endif
    </span>
</li>
