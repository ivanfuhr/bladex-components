<button
    type="button"
    {{
        $attributes->class([
            'color-picker__swatch size-6 rounded-md ring-1 ring-zinc-950/10 transition-transform ring-inset hover:scale-105 focus-visible:ring-2 focus-visible:ring-zinc-950/20 focus-visible:outline-none data-[selected=true]:ring-2 data-[selected=true]:ring-zinc-950/30 dark:ring-white/15 dark:focus-visible:ring-zinc-300/30 dark:data-[selected=true]:ring-zinc-50/40',
        ])
    }}
    data-color-picker-swatch="{{ $value }}"
    style="background-color: {{ $value }}"
    role="option"
    aria-label="{{ __('Select :color', ['color' => $swatchLabel]) }}"
    @if ($disabled) disabled @endif
></button>
