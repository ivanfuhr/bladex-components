<div {{ $rootAttributes }}>
    <input type="hidden" name="{{ $name }}" value="{{ $currentValue }}" data-rating-hidden-input />

    <div class="rating__stars flex items-center gap-0.5" data-rating-stars>
        @foreach ($stars as $star)
            <button
                type="button"
                class="rating__star inline-flex items-center justify-center rounded-sm text-zinc-500 transition-colors hover:text-amber-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:text-zinc-400 dark:hover:text-amber-400 dark:focus-visible:ring-zinc-300/20 {{ $starSize }} {{ $star['active'] ? '!text-amber-700 dark:!text-amber-400' : '' }}"
                data-rating-star
                data-rating-value="{{ $star['value'] }}"
                role="radio"
                aria-checked="{{ $star['checked'] ? 'true' : 'false' }}"
                aria-label="{{ __('Rate :value stars', ['value' => $star['value']]) }}"
                tabindex="{{ $star['tabStop'] ? '0' : '-1' }}"
                @if ($disabled) disabled @endif
            >
                <x-ui::icon name="star" class="{{ $starSize }}" data-rating-star-icon />
            </button>
        @endforeach
    </div>
</div>
