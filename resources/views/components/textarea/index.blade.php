<div {{ $wrapperAttributes }}>
    @if ($useScrollArea)
        <div {{ $frameAttributes }}>
            <textarea {{ $controlAttributes }}>{{ $slot }}</textarea>
            <x-std::scroll-area.scrollbar orientation="vertical" />
        </div>
    @else
        <textarea {{ $controlAttributes }}>{{ $slot }}</textarea>
    @endif

    @if ($counter)
        <div
            class="textarea__counter mt-1 text-right text-xs text-zinc-500 dark:text-zinc-400"
            data-textarea-counter-display
            aria-live="polite"
            aria-atomic="true"
        ></div>
    @endif
</div>
