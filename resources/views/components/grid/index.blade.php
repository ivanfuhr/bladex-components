@if ($usesContainerWrapper)
    <div {{ $wrapperAttributes }}>
        <div {{ $gridAttributes }}>{{ $slot }}</div>
    </div>
@else
    <div {{ $mergedAttributes }}>{{ $slot }}</div>
@endif
