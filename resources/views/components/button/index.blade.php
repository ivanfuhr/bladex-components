<{{ $tag }} {{ $mergedAttributes }}>
    @if ($hasLeading)
        <span @class(['button__leading', 'inline-flex shrink-0 items-center']) data-button-leading>
            @if ($leadingContent instanceof \Illuminate\View\ComponentSlot)
                {{ $leadingContent }}
            @else
                {{ $leadingContent }}
            @endif
        </span>
    @endif

    @unless ($slotEmpty)
        <span @class(['button__label', 'inline-flex items-center gap-2']) data-button-label> {{ $slot }} </span>
    @endunless

    @if ($isLoading)
        <span @class(['button__loading', 'inline-flex shrink-0 items-center']) data-button-loading aria-hidden="true">
            <x-std::icon.loading />
            <span class="sr-only">{{ __('Loading') }}</span>
        </span>
    @elseif ($hasTrailing)
        <span @class(['button__trailing', 'inline-flex shrink-0 items-center']) data-button-trailing>
            @if ($trailingContent instanceof \Illuminate\View\ComponentSlot)
                {{ $trailingContent }}
            @else
                {{ $trailingContent }}
            @endif
        </span>
    @endif
</{{ $tag }}>
