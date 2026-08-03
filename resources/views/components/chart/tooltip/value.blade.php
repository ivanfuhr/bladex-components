<div {{ $attributes->class(['flex items-center gap-2 p-2 text-xs text-zinc-500 dark:text-zinc-300']) }}>
    {{ $slot }}

    @if (is_string($label) && $label !== '')
        <div class="text-zinc-800 dark:text-white">{{ $label }}</div>
    @elseif ($label)
        {{ $label }}
    @endif

    @if (filled($field))
        <div class="flex-1"></div>

        <div class="text-zinc-800 dark:text-white">
            <span
                data-chart-slot
                data-field="{{ $field }}"
                @if (filled($encodedFormat)) data-format="{{ $encodedFormat }}" @endif
                @if (filled($prefix)) data-prefix="{{ $prefix }}" @endif
                @if (filled($suffix)) data-suffix="{{ $suffix }}" @endif
            ></span>
        </div>
    @endif
</div>
