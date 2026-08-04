@php
    $hasSlotLogo = isset($logo) && $logo instanceof \Illuminate\View\ComponentSlot;
    $hasUrlLogo = filled($logo) && ! $hasSlotLogo;
    $hasDarkLogo = filled($logoDark ?? null);
@endphp

@if ($hasSlotLogo)
    <div {{ $logo->attributes->class($logoWrapperClasses) }}>{{ $logo }}</div>
@elseif ($hasUrlLogo || $hasDarkLogo)
    <div @class($logoWrapperClasses)>
        @if ($hasDarkLogo)
            <img src="{{ $logo }}" alt="{{ $alt }}" @class([$imageClasses, 'dark:hidden']) />
            <img src="{{ $logoDark }}" alt="{{ $alt }}" @class([$imageClasses, 'hidden dark:block']) />
        @else
            <img src="{{ $logo }}" alt="{{ $alt }}" @class($imageClasses) />
        @endif
    </div>
@endif
