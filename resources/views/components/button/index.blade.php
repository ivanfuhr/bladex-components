@props([
    'variant' => 'outline',
    'size' => null,
    'color' => null,
    'type' => 'button',
    'href' => null,
    'as' => null,
    'square' => false,
    'loading' => null,
    'leading' => null,
    'trailing' => null,
])

@php
    use Illuminate\View\ComponentSlot;
    use Ivanfuhr\Stencil\Support\Button\ButtonClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $interactionState = app(InteractionStateAttributes::class);

    $resolveAffix = static function (mixed $value): array {
        if ($value instanceof ComponentSlot) {
            return [! $value->isEmpty(), $value->isEmpty() ? null : $value];
        }

        if (filled($value)) {
            return [true, $value];
        }

        return [false, null];
    };

    [$hasLeading, $leadingContent] = $resolveAffix($leading ?? null);
    [$hasTrailing, $trailingContent] = $resolveAffix($trailing ?? null);

    $slotEmpty = $slot->isEmpty();
    $iconOnly = $slotEmpty && ($hasLeading || $hasTrailing || (bool) $square);

    $classMap = app(ButtonClassMap::class);

    $buttonClasses = $classMap->classes(
        $variant,
        $size,
        $color,
        [
            'hasLeading' => $hasLeading,
            'hasTrailing' => $hasTrailing,
            'square' => (bool) $square,
            'iconOnly' => $iconOnly,
        ],
    );

    $useLink = filled($href) || $as === 'a';
    $tag = $useLink ? 'a' : 'button';

    $mergedAttributes = $attributes
        ->except(['loading'])
        ->class($buttonClasses)
        ->merge([
            'data-button' => true,
        ]);

    $mergedAttributes = $interactionState->apply($mergedAttributes, [
        'nativeDisabled' => ! $useLink,
        'loading' => $loading === true ? true : null,
    ]);

    $isLoading = $interactionState->isLoading($mergedAttributes);

    if ($useLink) {
        $mergedAttributes = $mergedAttributes->merge([
            'href' => $href ?? '#',
        ]);
    } else {
        $mergedAttributes = $mergedAttributes->merge([
            'type' => $type,
        ]);
    }

    if ($iconOnly) {
        $mergedAttributes = $mergedAttributes->merge(['data-button-icon-only' => true]);
    }
@endphp

<{{ $tag }} {{ $mergedAttributes }}>
    @if ($hasLeading)
        <span @class(['button__leading', 'inline-flex shrink-0 items-center']) data-button-leading>
            @if ($leadingContent instanceof ComponentSlot)
                {{ $leadingContent }}
            @else
                {{ $leadingContent }}
            @endif
        </span>
    @endif

    @unless ($slotEmpty)
        <span @class(['button__label', 'inline-flex items-center']) data-button-label>
            {{ $slot }}
        </span>
    @endunless

    @if ($isLoading)
        <span @class(['button__loading', 'inline-flex shrink-0 items-center']) data-button-loading aria-hidden="true">
            @include('stencil::internals.loading-icon')
        </span>
    @elseif ($hasTrailing)
        <span @class(['button__trailing', 'inline-flex shrink-0 items-center']) data-button-trailing>
            @if ($trailingContent instanceof ComponentSlot)
                {{ $trailingContent }}
            @else
                {{ $trailingContent }}
            @endif
        </span>
    @endif
</{{ $tag }}>
