<div class="flex w-full min-w-0 items-center gap-2">
    <button {{ $triggerAttributes }} data-time-picker-trigger>
        <span class="flex min-w-0 flex-1 items-center gap-2">
            <x-ui::icon name="clock" class="size-4 shrink-0 opacity-50" />
            <x-ui::time-picker.selected :$placeholder />
        </span>
        <x-ui::icon name="chevron-down" class="size-4 shrink-0 opacity-50" />
    </button>
    @if ($clearable)
        <button
            type="button"
            class="inline-flex size-8 shrink-0 items-center justify-center rounded-md text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800"
            data-time-picker-clear
            aria-label="{{ __('Clear time') }}"
        >
            <x-ui::icon name="x" class="size-4" />
        </button>
    @endif
</div>
