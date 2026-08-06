<div class="date-picker__input-trigger flex w-full items-center gap-2" data-date-picker-trigger>
    <x-std::input {{
        $attributes->merge([
            'type' => 'text',
            'placeholder' => $placeholder,
            'invalid' => $invalid,
            'disabled' => $disabled,
            'size' => $size,
            'readonly' => true,
            'data-date-picker-input' => true,
            'aria-haspopup' => 'dialog',
            'aria-expanded' => 'false',
        ])->merge(filled($panelId) ? ['aria-controls' => $panelId] : [])
    }} />
    @if ($clearable)
        <button
            type="button"
            class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800"
            data-date-picker-clear
            aria-label="{{ __('Clear date') }}"
        >
            <x-std::icon name="x" class="size-4" />
        </button>
    @endif
</div>
