@props([
    'type' => 'text',
    'invalid' => false,
    'size' => null,
    'inGroup' => false,
    'prefix' => null,
    'suffix' => null,
    'leading' => null,
    'trailing' => null,
])

@php
    use Illuminate\View\ComponentSlot;

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

    $controlClasses = collect([
        'bladex-input__control',
        'flex w-full min-w-0 rounded-md border border-zinc-200 bg-white px-3 py-1 text-base text-zinc-950 shadow-sm transition-colors',
        'file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-zinc-950',
        'placeholder:text-zinc-500',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-0',
        'disabled:cursor-not-allowed disabled:opacity-50',
        'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50 dark:placeholder:text-zinc-400 dark:file:text-zinc-50',
        'dark:focus-visible:ring-zinc-300/20',
        'aria-invalid:border-red-500 aria-invalid:text-red-950 aria-invalid:placeholder:text-red-400',
        'aria-invalid:focus-visible:ring-red-500/20',
        'dark:aria-invalid:border-red-500 dark:aria-invalid:text-red-50',
        $size === 'sm' ? 'h-8 px-2.5 text-sm' : 'h-9',
        $hasLeading ? 'pl-9' : null,
        $hasTrailing ? 'pr-9' : null,
        $invalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
        $useInGroup ? 'shadow-none focus-visible:z-10' : null,
        $prefixText !== null && $suffixText !== null ? 'rounded-none border-l-0 border-r-0' : null,
        $prefixText !== null && $suffixText === null ? 'rounded-l-none border-l-0' : null,
        $suffixText !== null && $prefixText === null ? 'rounded-r-none border-r-0' : null,
        $useInGroup && ! $hasGroupAffix ? 'rounded-none' : null,
    ])->filter()->implode(' ');

    $wrapperClasses = collect([
        'bladex-input',
        'relative flex w-full min-w-0 items-stretch',
        $hasGroupAffix ? 'flex-1' : null,
        $hasLeading || $hasTrailing ? 'bladex-input--with-affixes' : null,
        $hasGroupAffix ? null : $attributes->get('class'),
    ])->filter()->implode(' ');

    $groupClasses = collect([
        'bladex-input-group',
        'flex w-full min-w-0 items-stretch',
        $hasGroupAffix ? $attributes->get('class') : null,
    ])->filter()->implode(' ');

    $controlExtraClass = $attributes->get('class:input') ?? $attributes->get('input:class');

    $controlAttributes = $attributes
        ->except(['class', 'class:input', 'input:class', 'prefix', 'suffix', 'leading', 'trailing'])
        ->class(collect([$controlClasses, $controlExtraClass])->filter()->implode(' '))
        ->merge([
            'type' => $type,
            'data-bladex-input-control' => true,
        ]);

    if ($invalid) {
        $controlAttributes = $controlAttributes->merge(['aria-invalid' => 'true']);
    }

    $affixIconClasses = $size === 'sm'
        ? '[&_[data-bladex-icon]]:size-3.5'
        : '[&_[data-bladex-icon]]:size-4';

    $leadingAffixClasses = collect([
        'bladex-input__leading',
        'pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center',
        $affixIconClasses,
        'text-zinc-500 dark:text-zinc-400',
    ])->implode(' ');

    $trailingAffixClasses = collect([
        'bladex-input__trailing',
        'absolute inset-y-0 right-0 flex w-9 items-center justify-center',
        $affixIconClasses,
        'text-zinc-500 dark:text-zinc-400',
    ])->implode(' ');
@endphp

@if ($hasGroupAffix)
    <div @class([$groupClasses]) data-bladex-input-group>
        @if ($prefixText !== null)
            <div
                @class([
                    'bladex-input-group__prefix',
                    'inline-flex shrink-0 items-center rounded-l-md border border-r-0 border-zinc-200 bg-zinc-50 px-3 text-sm text-zinc-600',
                    'dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400',
                ])
                data-bladex-input-group-prefix
            >
                {{ $prefixText }}
            </div>
        @endif
@endif

<div @class([$wrapperClasses]) data-bladex-input>
    @if ($hasLeading)
        <div @class([$leadingAffixClasses])>
            @if ($leadingContent instanceof ComponentSlot)
                {{ $leadingContent }}
            @else
                <span class="bladex-input__leading-text">{{ $leadingContent }}</span>
            @endif
        </div>
    @endif

    <input {{ $controlAttributes }} />

    @if ($hasTrailing)
        <div @class([$trailingAffixClasses])>
            @if ($trailingContent instanceof ComponentSlot)
                {{ $trailingContent }}
            @else
                <span class="bladex-input__trailing-text">{{ $trailingContent }}</span>
            @endif
        </div>
    @endif
</div>

@if ($hasGroupAffix)
        @if ($suffixText !== null)
            <div
                @class([
                    'bladex-input-group__suffix',
                    'inline-flex shrink-0 items-center rounded-r-md border border-l-0 border-zinc-200 bg-zinc-50 px-3 text-sm text-zinc-600',
                    'dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400',
                ])
                data-bladex-input-group-suffix
            >
                {{ $suffixText }}
            </div>
        @endif
    </div>
@endif
