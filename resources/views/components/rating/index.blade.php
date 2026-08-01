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
    'controlId' => null,
])

@php
    if (! filled($name)) {
        throw new \InvalidArgumentException('The rating component requires a [name] attribute.');
    }

    $invalid = $invalid || $fieldInvalid;
    $maxStars = max(1, min(10, (int) $max));
    $currentValue = filled($value) ? max(0, min($maxStars, (int) $value)) : 0;

    $resolvedControlId = $attributes->get('id')
        ?? $controlId
        ?? $name;

    $rootClasses = collect([
        'rating flex min-w-0 items-center gap-1',
        'w-full' => ! filled($attributes->get('class')),
    ])->filter()->implode(' ');

    $rootAttributes = $attributes
        ->except(['name', 'value', 'max', 'invalid', 'disabled', 'size', 'id'])
        ->class($rootClasses)
        ->merge([
            'id' => $resolvedControlId,
            'data-rating' => true,
            'data-rating-max' => $maxStars,
            'role' => 'radiogroup',
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
            @php
                $isChecked = $i === $currentValue;
                $isTabStop = $isChecked || ($currentValue === 0 && $i === 1);
            @endphp
            <button
                type="button"
                class="rating__star inline-flex items-center justify-center rounded-sm text-zinc-500 transition-colors hover:text-amber-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:text-zinc-400 dark:hover:text-amber-400 dark:focus-visible:ring-zinc-300/20 {{ $starSize }} {{ $i <= $currentValue ? '!text-amber-700 dark:!text-amber-400' : '' }}"
                data-rating-star
                data-rating-value="{{ $i }}"
                role="radio"
                aria-checked="{{ $isChecked ? 'true' : 'false' }}"
                aria-label="{{ __('stencil::messages.rating_star', ['value' => $i]) }}"
                tabindex="{{ $isTabStop ? '0' : '-1' }}"
                @if ($disabled) disabled @endif
            >
                <x-stencil::icon name="star" class="{{ $starSize }}" data-rating-star-icon />
            </button>
        @endfor
    </div>
</div>
