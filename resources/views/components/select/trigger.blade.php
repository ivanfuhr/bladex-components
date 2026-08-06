<button {{ $triggerAttributes }} data-select-trigger>
    <span @class([
        'select__trigger-inner flex min-w-0 flex-1 gap-2',
        'flex-wrap items-center' => $chipsLayout,
        'items-center' => ! $chipsLayout,
    ])>
        {{ $slot }}
    </span>
    <x-std::icon
        name="chevron-down"
        class="{{ $chevronClasses }} text-zinc-500 transition-transform duration-200 group-aria-expanded:rotate-180 dark:text-zinc-400"
        data-select-chevron
        aria-hidden="true"
    />
</button>
