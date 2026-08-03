<div {{ $wrapperAttributes }}>
    <textarea {{ $controlAttributes }}>{{ $slot }}</textarea>

    @if ($counter)
        <div
            class="textarea__counter mt-1 text-right text-xs text-zinc-500 dark:text-zinc-400"
            data-textarea-counter-display
        ></div>
    @endif
</div>
