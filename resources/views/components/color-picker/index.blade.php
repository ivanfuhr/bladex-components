@props([
    'name' => null,
    'value' => null,
    'invalid' => false,
    'disabled' => false,
    'size' => null,
    'swatches' => null,
    'dropper' => false,
    'placeholder' => null,
])

@aware([
    'fieldInvalid' => false,
])

@php
    use Illuminate\Support\Arr;
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;
    use Ivanfuhr\Stencil\Support\Typography\TypographyClassMap;

    if (! filled($name)) {
        throw new \InvalidArgumentException('The color-picker component requires a [name] attribute.');
    }

    $invalid = $invalid || $fieldInvalid;
    $currentValue = filled($value) ? (string) $value : '#000000';

    if (! preg_match('/^#[0-9a-fA-F]{6}$/', $currentValue)) {
        $currentValue = '#000000';
    }

    $defaultSwatches = [
        '#ef4444', '#f97316', '#f59e0b', '#eab308', '#84cc16', '#22c55e',
        '#10b981', '#14b8a6', '#06b6d4', '#0ea5e9', '#3b82f6', '#6366f1',
        '#8b5cf6', '#a855f7', '#d946ef', '#ec4899', '#f43f5e',
        '#fafafa', '#e4e4e7', '#a1a1aa', '#71717a', '#3f3f46', '#27272a', '#18181b',
    ];

    $showSwatches = $swatches !== false;
    $swatchPalette = match (true) {
        is_array($swatches) => collect($swatches)
            ->map(function ($swatch) {
                if (is_array($swatch)) {
                    return [
                        'value' => (string) ($swatch[0] ?? $swatch['value'] ?? '#000000'),
                        'label' => (string) ($swatch[1] ?? $swatch['label'] ?? $swatch[0] ?? '#000000'),
                    ];
                }

                return [
                    'value' => (string) $swatch,
                    'label' => (string) $swatch,
                ];
            })
            ->filter(fn (array $swatch) => preg_match('/^#[0-9a-fA-F]{6}$/', $swatch['value']) === 1)
            ->values()
            ->all(),
        default => collect($defaultSwatches)
            ->map(fn (string $color) => ['value' => $color, 'label' => $color])
            ->all(),
    };

    $pickerId = 'color-picker-'.str_replace('.', '', uniqid('', true));
    $popoverId = $pickerId.'-popover';

    $typography = app(TypographyClassMap::class);
    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $isSmall = $size === 'sm';
    $swatchWidth = $isSmall ? 'w-9' : 'w-10';
    $placeholderText = filled($placeholder) ? (string) $placeholder : '#000000';

    $rootClasses = collect([
        'color-picker',
        'group/color-picker relative flex min-w-0',
        'w-full' => ! filled($attributes->get('class')),
    ])->filter()->implode(' ');

    $rootAttributes = $attributes
        ->except(['name', 'value', 'invalid', 'disabled', 'size', 'swatches', 'dropper', 'placeholder'])
        ->class($rootClasses)
        ->merge([
            'data-color-picker' => true,
            'data-color-picker-id' => $pickerId,
        ]);

    if ($showSwatches) {
        $rootAttributes = $rootAttributes->merge([
            'data-color-picker-swatches' => json_encode(Arr::pluck($swatchPalette, 'value')),
        ]);
    }

    if ($dropper) {
        $rootAttributes = $rootAttributes->merge(['data-color-picker-dropper' => true]);
    }

    if ($disabled) {
        $rootAttributes = $rootAttributes->merge(['data-disabled' => 'true']);
    }

    if ($invalid) {
        $rootAttributes = $rootAttributes->merge([
            'data-invalid' => 'true',
            'aria-invalid' => 'true',
        ]);
    }

    $triggerClasses = collect([
        'color-picker__trigger',
        'relative flex min-w-0 overflow-hidden rounded-md border border-zinc-200 bg-white shadow-sm transition-colors',
        'focus-within:outline-none focus-within:ring-2 focus-within:ring-zinc-950/10 focus-within:ring-offset-0',
        'dark:border-zinc-800 dark:bg-zinc-950 dark:focus-within:ring-zinc-300/20',
        $formControl->invalidFieldClasses(),
        $invalid ? 'border-red-500 focus-within:ring-red-500/20 dark:border-red-500' : null,
        $isSmall ? 'h-8' : 'h-9',
        $disabled ? 'opacity-50' : null,
    ])->filter()->implode(' ');

    $swatchButtonClasses = collect([
        'color-picker__swatch-trigger',
        'relative flex shrink-0 items-center justify-center border-r border-zinc-200 bg-zinc-50 p-1.5',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-zinc-950/10',
        'dark:border-zinc-800 dark:bg-zinc-900/80 dark:focus-visible:ring-zinc-300/20',
        $swatchWidth,
        $disabled ? 'cursor-not-allowed' : 'cursor-pointer',
    ])->filter()->implode(' ');

    $previewClasses = collect([
        'color-picker__preview',
        'block size-full min-h-[1.125rem] min-w-[1.125rem] rounded-[3px] ring-1 ring-inset ring-zinc-950/10 dark:ring-white/15',
        $isSmall ? 'min-h-4 min-w-4' : null,
    ])->filter()->implode(' ');

    $hexClasses = collect([
        'color-picker__hex',
        'min-w-0 flex-1 border-0 bg-transparent shadow-none',
        $typography->inputControlClasses($size),
        'font-mono uppercase tracking-wide text-zinc-950 placeholder:text-zinc-500',
        'focus-visible:outline-none focus-visible:ring-0',
        'dark:text-zinc-50 dark:placeholder:text-zinc-400',
        $isSmall ? 'px-2.5' : 'px-3',
        $invalid ? 'text-red-950 dark:text-red-50' : null,
    ])->filter()->implode(' ');

    $hexAttributes = $interactionState->apply(
        $attributes
            ->except(['name', 'value', 'invalid', 'disabled', 'size', 'swatches', 'dropper', 'placeholder', 'class'])
            ->class($hexClasses)
            ->merge([
                'type' => 'text',
                'data-color-picker-hex' => true,
                'value' => strtoupper($currentValue),
                'placeholder' => $placeholderText,
                'spellcheck' => 'false',
                'inputmode' => 'text',
                'autocomplete' => 'off',
                'aria-label' => __('stencil::messages.color_picker_hex'),
                'aria-controls' => $popoverId,
                'aria-expanded' => 'false',
            ]),
        ['nativeDisabled' => true],
    );

    if ($disabled) {
        $hexAttributes = $hexAttributes->merge(['disabled' => true]);
    }

    if ($invalid) {
        $hexAttributes = $hexAttributes->merge(['aria-invalid' => 'true']);
    }

    $popoverClasses = collect([
        'color-picker__popover',
        'z-[200] flex w-[min(18rem,calc(100vw-1rem))] flex-col gap-3 rounded-md border border-zinc-200 bg-white p-3 shadow-md',
        'dark:border-zinc-800 dark:bg-zinc-950',
    ])->implode(' ');
@endphp

<div {{ $rootAttributes }}>
    <input type="hidden" name="{{ $name }}" value="{{ $currentValue }}" data-color-picker-hidden-input />

    <div @class([$triggerClasses]) data-color-picker-trigger>
        <button
            type="button"
            @class([$swatchButtonClasses])
            data-color-picker-swatch-trigger
            aria-label="{{ __('stencil::messages.color_picker_open') }}"
            aria-controls="{{ $popoverId }}"
            aria-expanded="false"
            aria-haspopup="dialog"
            @if ($disabled) disabled @endif
        >
            <span
                class="{{ $previewClasses }}"
                data-color-picker-preview
                style="background-color: {{ $currentValue }}"
                aria-hidden="true"
            ></span>
        </button>

        <input {{ $hexAttributes }} />
    </div>

    <div
        id="{{ $popoverId }}"
        @class([$popoverClasses])
        data-color-picker-popover
        role="dialog"
        aria-label="{{ __('stencil::messages.color_picker_open') }}"
        hidden
    >
        <div class="flex flex-col gap-3">
            <div
                class="color-picker__area relative h-36 w-full cursor-crosshair overflow-hidden rounded-md"
                data-color-picker-area
                role="group"
                aria-label="{{ __('stencil::messages.color_picker_saturation_value') }}"
            >
                <div class="pointer-events-none absolute inset-0" data-color-picker-area-base></div>
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-white to-transparent"></div>
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                <div
                    class="color-picker__area-thumb pointer-events-none absolute size-4 -translate-x-1/2 -translate-y-1/2 rounded-full border-2 border-white shadow-md ring-1 ring-zinc-950/20 dark:border-zinc-950 dark:ring-white/20"
                    data-color-picker-area-thumb
                ></div>
            </div>

            <div class="flex items-center gap-2">
                <div class="relative min-w-0 flex-1">
                    <input
                        type="range"
                        min="0"
                        max="360"
                        step="1"
                        value="0"
                        class="color-picker__hue-slider [&::-webkit-slider-thumb]:size-4 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-white [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:shadow-md [&::-moz-range-thumb]:size-4 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:border-2 [&::-moz-range-thumb]:border-white [&::-moz-range-thumb]:bg-white [&::-moz-range-thumb]:shadow-md h-3 w-full cursor-pointer appearance-none rounded-full bg-transparent focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:focus-visible:ring-zinc-300/20"
                        style="
                            background: linear-gradient(
                                to right,
                                #ff0000,
                                #ffff00,
                                #00ff00,
                                #00ffff,
                                #0000ff,
                                #ff00ff,
                                #ff0000
                            );
                        "
                        data-color-picker-hue
                        aria-label="{{ __('stencil::messages.color_picker_hue') }}"
                        @if ($disabled) disabled @endif
                    />
                </div>

                @if ($dropper)
                    <button
                        type="button"
                        class="inline-flex size-9 shrink-0 items-center justify-center rounded-md border border-zinc-200 text-zinc-600 transition-colors hover:bg-zinc-50 hover:text-zinc-950 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50 dark:border-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-900 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20"
                        data-color-picker-dropper
                        aria-label="{{ __('stencil::messages.color_picker_dropper') }}"
                        hidden
                        @if ($disabled) disabled @endif
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4" aria-hidden="true">
                            <path d="m2 22 1-1h3l9.5-9.5a2.12 2.12 0 0 0-3-3L3 18v3Z" />
                            <path d="M15 6l3 3" />
                            <path d="m18 3 3 3" />
                        </svg>
                    </button>
                @endif
            </div>

            @if ($showSwatches && $swatchPalette !== [])
                <div
                    class="color-picker__swatches grid grid-cols-8 gap-1.5"
                    data-color-picker-swatches
                    role="listbox"
                    aria-label="{{ __('stencil::messages.color_picker_swatches') }}"
                >
                    @foreach ($swatchPalette as $swatch)
                        <button
                            type="button"
                            class="color-picker__swatch size-6 rounded-md ring-1 ring-zinc-950/10 transition-transform ring-inset hover:scale-105 focus-visible:ring-2 focus-visible:ring-zinc-950/20 focus-visible:outline-none data-[selected=true]:ring-2 data-[selected=true]:ring-zinc-950/30 dark:ring-white/15 dark:focus-visible:ring-zinc-300/30 dark:data-[selected=true]:ring-zinc-50/40"
                            data-color-picker-swatch="{{ $swatch['value'] }}"
                            style="background-color: {{ $swatch['value'] }}"
                            role="option"
                            aria-label="{{ __('stencil::messages.color_picker_swatch', ['color' => $swatch['label']]) }}"
                            @if ($disabled) disabled @endif
                        ></button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
