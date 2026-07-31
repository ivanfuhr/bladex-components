@props([
    'name' => null,
    'value' => null,
    'max' => 5,
    'invalid' => false,
    'disabled' => false,
    'size' => null,
])

@aware([
    'fieldInvalid' => false,
])

@php
    if (! filled($name)) {
        throw new \InvalidArgumentException('The rating component requires a [name] attribute.');
    }

    $invalid = $invalid || $fieldInvalid;
    $maxStars = max(1, min(10, (int) $max));
    $currentValue = filled($value) ? max(0, min($maxStars, (int) $value)) : 0;

    $rootClasses = collect([
        'rating flex min-w-0 items-center gap-1',
        'w-full' => ! filled($attributes->get('class')),
    ])->filter()->implode(' ');

    $rootAttributes = $attributes
        ->except(['name', 'value', 'max', 'invalid', 'disabled', 'size'])
        ->class($rootClasses)
        ->merge([
            'data-rating' => true,
            'data-rating-max' => $maxStars,
            'role' => 'slider',
            'aria-valuemin' => '0',
            'aria-valuemax' => (string) $maxStars,
            'aria-valuenow' => (string) $currentValue,
            'aria-label' => __('stencil::messages.rating_label'),
        ]);

    if ($disabled) {
        $rootAttributes = $rootAttributes->merge(['data-disabled' => 'true']);
    }

    if ($invalid) {
        $rootAttributes = $rootAttributes->merge([
            'data-invalid' => 'true',
            'aria-invalid' => 'true',
        ]);
    }

    $starSize = $size === 'sm' ? 'size-5' : 'size-6';
@endphp

<div {{ $rootAttributes }}>
    <input type="hidden" name="{{ $name }}" value="{{ $currentValue }}" data-rating-hidden-input />

    <div class="rating__stars flex items-center gap-0.5" data-rating-stars>
        @for ($i = 1; $i <= $maxStars; $i++)
            <button
                type="button"
                class="rating__star inline-flex items-center justify-center rounded-sm text-zinc-300 transition-colors hover:text-amber-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:text-zinc-600 dark:hover:text-amber-400 dark:focus-visible:ring-zinc-300/20 {{ $starSize }} {{ $i <= $currentValue ? '!text-amber-400 dark:!text-amber-400' : '' }}"
                data-rating-star
                data-rating-value="{{ $i }}"
                aria-label="{{ __('stencil::messages.rating_star', ['value' => $i]) }}"
                @if ($disabled) disabled @endif
            >
                <x-stencil::icon name="star" class="{{ $starSize }}" data-rating-star-icon />
            </button>
        @endfor
    </div>
</div>
