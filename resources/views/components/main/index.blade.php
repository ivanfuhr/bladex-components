<main {{ $shellAttributes }}>
    <x-std::scroll-area class="min-h-0 w-full flex-1" :type="$type" :scroll-hide-delay="$scrollHideDelay">
        <div {{ $contentAttributes }}>{{ $slot }}</div>
    </x-std::scroll-area>
</main>
