<div class="combobox__input-wrap relative flex w-full min-w-0 items-stretch" data-combobox-input-wrap>
    @if ($multiple)
        @if ($slot->isEmpty())
            <span
                class="combobox__value shrink-0 text-sm text-zinc-500 dark:text-zinc-400"
                data-combobox-value
                data-placeholder="{{ $resolvedPlaceholder }}"
            ></span>
        @else
            {{ $slot }}
        @endif
        <input
            {{ $inputAttributes }}
            class="combobox__input combobox__input--multiple min-w-[6rem] flex-1 border-0 bg-transparent p-0 text-sm shadow-none focus-visible:ring-0"
            data-combobox-filter-input
            @if ($resolvedPlaceholder) placeholder="{{ $resolvedPlaceholder }}" @endif
        />
    @else
        <input {{ $inputAttributes }} data-combobox-input />
    @endif
    <button
        type="button"
        class="combobox__toggle absolute inset-y-0 right-0 z-10 flex w-9 items-center justify-center text-zinc-500 disabled:cursor-not-allowed disabled:opacity-50 dark:text-zinc-400"
        data-combobox-toggle
        tabindex="-1"
        aria-label="{{ __('Toggle options') }}"
        aria-expanded="false"
        @if (filled($resolvedListboxId)) aria-controls="{{ $resolvedListboxId }}" @endif
        @if ($disabled) disabled @endif
    >
        <x-std::icon
            name="chevron-down"
            class="{{ $chevronClasses }} text-zinc-500 transition-transform duration-200 dark:text-zinc-400"
            data-combobox-chevron
        />
    </button>
</div>
