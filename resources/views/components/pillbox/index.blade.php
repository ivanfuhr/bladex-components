@props([
    'name' => null,
    'value' => [],
    'placeholder' => null,
    'max' => null,
    'invalid' => false,
    'disabled' => false,
    'size' => null,
])

@aware([
    'fieldInvalid' => false,
])

@php
    use Illuminate\Support\Arr;
    use Illuminate\Support\Str;

    if (! filled($name)) {
        throw new \InvalidArgumentException('The pillbox component requires a [name] attribute.');
    }

    $invalid = $invalid || $fieldInvalid;

    $fieldName = Str::endsWith($name, '[]') ? $name : $name.'[]';

    $normalizedValue = collect(Arr::wrap($value))
        ->filter(fn ($item) => filled($item))
        ->map(fn ($item) => (string) $item)
        ->values()
        ->all();

    $resolvedPlaceholder = filled($placeholder)
        ? $placeholder
        : __('stencil::messages.pillbox_placeholder');

    $rootClasses = collect([
        'pillbox flex min-w-0 flex-col gap-2',
        'w-full' => ! filled($attributes->get('class')),
    ])->filter()->implode(' ');

    $rootAttributes = $attributes
        ->except(['name', 'value', 'placeholder', 'max', 'invalid', 'disabled', 'size'])
        ->class($rootClasses)
        ->merge([
            'data-pillbox' => true,
            'data-pillbox-name' => $fieldName,
            'data-pillbox-value' => json_encode($normalizedValue, JSON_THROW_ON_ERROR),
        ]);

    if ($max !== null) {
        $rootAttributes = $rootAttributes->merge([
            'data-pillbox-max' => max(1, (int) $max),
        ]);
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

    $chipSizeClasses = $size === 'sm'
        ? 'text-xs px-1.5 py-0'
        : 'text-xs px-2 py-0.5';

    $chipClasses = collect([
        'pillbox__chip',
        'inline-flex max-w-full items-center gap-1 rounded-md border border-zinc-200 bg-zinc-50 font-medium text-zinc-700',
        'dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200',
        $chipSizeClasses,
    ])->implode(' ');

    $chipRemoveClasses = collect([
        'pillbox__chip-remove',
        'inline-flex shrink-0 items-center justify-center rounded-sm text-zinc-500 hover:text-zinc-900',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
        'dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20',
        $size === 'sm' ? 'size-3.5' : 'size-4',
    ])->implode(' ');
@endphp

<div {{ $rootAttributes }}>
    <div
        class="pillbox__field flex min-w-0 flex-wrap items-center gap-1 rounded-md border border-zinc-200 bg-white px-2 py-1.5 shadow-sm focus-within:ring-2 focus-within:ring-zinc-950/10 dark:border-zinc-800 dark:bg-zinc-950 dark:focus-within:ring-zinc-300/20 {{ $invalid ? 'border-red-500 dark:border-red-500' : '' }}"
        data-pillbox-field
    >
        <div class="pillbox__list flex min-w-0 flex-wrap items-center gap-1" data-pillbox-list></div>

        <input
            type="text"
            class="pillbox__input min-w-[8rem] flex-1 border-0 bg-transparent p-0 text-sm text-zinc-900 placeholder:text-zinc-500 focus:ring-0 focus:outline-none dark:text-zinc-50 dark:placeholder:text-zinc-400"
            data-pillbox-input
            placeholder="{{ $resolvedPlaceholder }}"
            autocomplete="off"
            @if ($disabled) disabled @endif
            @if ($invalid) aria-invalid="true" @endif
        />
    </div>

    <div data-pillbox-hidden-inputs data-pillbox-field-name="{{ $fieldName }}">
        @foreach ($normalizedValue as $tag)
            <input type="hidden" name="{{ $fieldName }}" value="{{ $tag }}" data-pillbox-hidden-input />
        @endforeach
    </div>

    <template data-pillbox-chip-template>
        <span class="{{ $chipClasses }}" data-pillbox-chip>
            <span class="min-w-0 truncate" data-pillbox-chip-label></span>
            <button
                type="button"
                class="{{ $chipRemoveClasses }}"
                data-pillbox-chip-remove
                aria-label="{{ __('stencil::messages.pillbox_remove') }}"
            >
                <x-stencil::icon name="x" class="{{ $size === 'sm' ? 'size-3' : 'size-3.5' }}" />
            </button>
        </span>
    </template>
</div>
