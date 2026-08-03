<div {{ $attributes->class(['flex items-center gap-2 p-2']) }}>
    {{ $slot }}

    @if (is_string($label) && $label !== '')
        <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $label }}</div>
    @elseif ($label)
        {{ $label }}
    @endif
</div>
