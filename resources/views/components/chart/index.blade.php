<div
    {{
        $attributes->class([
            'chart',
            'relative block w-full min-h-32 outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-2 dark:focus-visible:ring-zinc-300/20',
        ])->merge([
            'data-chart' => true,
            'role' => 'figure',
            'tabindex' => '0',
        ])
    }}
    @if (filled($label)) aria-label="{{ $label }}" @endif
    @if (filled($encodedValue)) data-chart-value="{{ $encodedValue }}" @endif
>
    <div class="sr-only" aria-live="polite" aria-atomic="true" data-chart-announcer></div>
    {{ $slot }}
</div>
