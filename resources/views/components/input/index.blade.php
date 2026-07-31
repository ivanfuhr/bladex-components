@props([
    'type' => 'text',
    'invalid' => false,
    'size' => null,
    'inGroup' => false,
    'prefix' => null,
    'suffix' => null,
    'leading' => null,
    'trailing' => null,
    'mask' => null,
    'viewable' => false,
    'copyable' => false,
    'counter' => false,
])

@aware([
    'fieldInvalid' => false,
])

@php
    use Illuminate\View\ComponentSlot;
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;
    use Ivanfuhr\Stencil\Support\Typography\TypographyClassMap;

    $invalid = $invalid || $fieldInvalid;

    $typography = app(TypographyClassMap::class);
    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $userClass = $attributes->get('class');
    $applyFullWidth = ! filled($userClass);

    $prefixText = filled($prefix) ? $prefix : null;
    $suffixText = filled($suffix) ? $suffix : null;
    $hasGroupAffix = $prefixText !== null || $suffixText !== null;
    $useInGroup = $inGroup || $hasGroupAffix;

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

    $hasViewable = $viewable && $type === 'password';
    $hasCopyable = (bool) $copyable;
    $hasCounter = (bool) $counter;
    $hasMask = filled($mask);
    $hasEnhancements = $hasViewable || $hasCopyable || $hasCounter || $hasMask;

    $trailingSlotIsIcon = false;

    if ($hasTrailing && $trailingContent instanceof ComponentSlot && ! $trailingContent->isEmpty()) {
        $trailingSlotIsIcon = str_contains($trailingContent->toHtml(), 'data-icon');
    }

    $trailingAffixWidth = $trailingSlotIsIcon ? 'w-9' : 'w-14';

    $leadingControlPadding = $hasLeading ? '!pl-9' : null;

    $trailingControlPadding = match (true) {
        ! $hasTrailing && ! $hasViewable && ! $hasCopyable => null,
        $hasTrailing && $trailingSlotIsIcon => '!pr-9',
        $hasTrailing => '!pr-14',
        $hasViewable && $hasCopyable => '!pr-[4.5rem]',
        $hasViewable || $hasCopyable => '!pr-9',
        default => null,
    };

    $controlClasses = collect([
        'input__control',
        'flex w-full min-w-0',
        $formControl->fieldSurfaceClasses($size),
        'placeholder:text-zinc-500 dark:placeholder:text-zinc-400',
        $formControl->invalidFieldClasses(),
        $leadingControlPadding,
        $trailingControlPadding,
        $invalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
        $useInGroup ? 'shadow-none focus-visible:z-10' : null,
        $prefixText !== null && $suffixText !== null ? 'rounded-none border-l-0 border-r-0' : null,
        $prefixText !== null && $suffixText === null ? 'rounded-l-none border-l-0' : null,
        $suffixText !== null && $prefixText === null ? 'rounded-r-none border-r-0' : null,
        $useInGroup && ! $hasGroupAffix ? 'rounded-none' : null,
    ])->filter()->implode(' ');

    $wrapperClasses = collect([
        'input',
        'relative flex min-w-0 items-stretch overflow-visible',
        $applyFullWidth && ! $hasGroupAffix ? 'w-full' : null,
        $hasGroupAffix ? 'flex-1' : null,
        $hasLeading || $hasTrailing || $hasViewable || $hasCopyable ? 'input--with-affixes' : null,
        ! $hasGroupAffix ? $userClass : null,
    ])->filter()->implode(' ');

    $groupClasses = collect([
        'input-group',
        'flex min-w-0 items-stretch',
        $applyFullWidth && $hasGroupAffix ? 'w-full' : null,
        $hasGroupAffix ? $userClass : null,
    ])->filter()->implode(' ');

    $controlExtraClass = $attributes->get('class:input') ?? $attributes->get('input:class');

    $controlAttributes = $interactionState->apply(
        $attributes
            ->except(['class', 'class:input', 'input:class', 'prefix', 'suffix', 'leading', 'trailing', 'mask', 'viewable', 'copyable', 'counter'])
            ->class([$controlClasses, $controlExtraClass])
            ->merge([
                'type' => $type,
                'data-input-control' => true,
            ]),
    );

    if ($hasMask) {
        $controlAttributes = $controlAttributes->merge([
            'data-input-mask-control' => true,
        ]);
    }

    if ($invalid) {
        $controlAttributes = $controlAttributes->merge(['aria-invalid' => 'true']);
    }

    $affixIconClasses = $size === 'sm'
        ? '[&_[data-icon]]:size-3.5'
        : '[&_[data-icon]]:size-4';

    $leadingAffixClasses = collect([
        'input__leading',
        'pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center',
        $affixIconClasses,
        '[&_[data-icon]]:text-zinc-500 dark:[&_[data-icon]]:text-zinc-400',
    ])->implode(' ');

    $trailingAffixClasses = collect([
        'input__trailing',
        'absolute inset-y-0 right-0 z-10 flex items-center justify-center',
        $trailingAffixWidth,
        $affixIconClasses,
        '[&_[data-icon]]:text-zinc-500 dark:[&_[data-icon]]:text-zinc-400',
    ])->implode(' ');
@endphp

@if ($hasGroupAffix)
    <div @class([$groupClasses]) data-input-group>
        @if ($prefixText !== null)
            <div
                @class([
                    'input-group__prefix',
                    'inline-flex shrink-0 items-center rounded-l-md border border-r-0 border-zinc-200 bg-zinc-50 px-3',
                    'dark:border-zinc-800 dark:bg-zinc-900',
                ])
                data-input-group-prefix
            >
                <x-stencil::text inline size="sm" variant="subtle">{{ $prefixText }}</x-stencil::text>
            </div>
        @endif
@endif

<div
    @class([$wrapperClasses])
    @if ($hasEnhancements) data-input-enhanced @if ($hasMask) data-input-mask="{{ $mask }}" @endif @if ($hasViewable) data-input-viewable @endif @if ($hasCopyable) data-input-copyable @endif @if ($hasCounter) data-input-counter @endif @endif
    data-input
>
    @if ($hasLeading)
        <div @class([$leadingAffixClasses])>
            @if ($leadingContent instanceof ComponentSlot)
                {{ $leadingContent }}
            @else
                <x-stencil::text
                    inline
                    size="sm"
                    variant="subtle"
                    class="input__leading-text"
                >{{ $leadingContent }}</x-stencil::text>
            @endif
        </div>
    @endif

    <input {{ $controlAttributes }} />

    @if ($hasTrailing)
        <div @class([$trailingAffixClasses])>
            @if ($trailingContent instanceof ComponentSlot)
                {{ $trailingContent }}
            @else
                <x-stencil::text
                    inline
                    size="sm"
                    variant="subtle"
                    class="input__trailing-text"
                >{{ $trailingContent }}</x-stencil::text>
            @endif
        </div>
    @endif

    @if ($hasViewable || $hasCopyable)
        <div class="input__actions absolute inset-y-0 right-0 z-10 flex items-center gap-0.5 pr-1">
            @if ($hasViewable)
                <button
                    type="button"
                    class="inline-flex size-8 items-center justify-center rounded-md text-zinc-500 hover:text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20"
                    data-input-view-toggle
                    aria-label="{{ __('stencil::messages.input_toggle_password') }}"
                    aria-pressed="false"
                >
                    <x-stencil::icon name="eye" class="size-4" />
                </button>
            @endif

            @if ($hasCopyable)
                <button
                    type="button"
                    class="inline-flex size-8 items-center justify-center rounded-md text-zinc-500 hover:text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20"
                    data-input-copy
                    aria-label="{{ __('stencil::messages.input_copy') }}"
                >
                    <x-stencil::icon name="clipboard" class="size-4" />
                </button>
            @endif
        </div>
    @endif
</div>

@if ($hasCounter)
    <div
        class="input__counter mt-1 text-right text-xs text-zinc-500 dark:text-zinc-400"
        data-input-counter-display
    ></div>
@endif

@if ($hasGroupAffix)
    @if ($suffixText !== null)
        <div
            @class([
                'input-group__suffix',
                'inline-flex shrink-0 items-center rounded-r-md border border-l-0 border-zinc-200 bg-zinc-50 px-3',
                'dark:border-zinc-800 dark:bg-zinc-900',
            ])
            data-input-group-suffix
        >
            <x-stencil::text inline size="sm" variant="subtle">{{ $suffixText }}</x-stencil::text>
        </div>
    @endif
    </div>
@endif
