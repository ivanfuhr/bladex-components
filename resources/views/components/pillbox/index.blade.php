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
            @if (filled($resolvedControlId)) id="{{ $resolvedControlId }}" @endif
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
                aria-label="{{ __('Remove tag') }}"
            >
                <x-ui::icon name="x" class="{{ $size === 'sm' ? 'size-3' : 'size-3.5' }}" />
            </button>
        </span>
    </template>
</div>
