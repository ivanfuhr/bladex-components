@if ($axis === 'x')
    <template data-chart-template="tick-label" @if (filled($encodedFormat)) data-format="{{ $encodedFormat }}" @endif>
        <g>
            <text
                {{
                    $attributes->merge([
                        'class' => 'text-xs font-medium text-zinc-500 dark:text-zinc-300',
                        'text-anchor' => 'middle',
                        'fill' => 'currentColor',
                        'dominant-baseline' => $position === 'top' ? 'text-after-edge' : 'text-before-edge',
                        'dy' => $position === 'top' ? '-1em' : '1em',
                    ])
                }}
            ></text>
        </g>
    </template>
@else
    <template data-chart-template="tick-label" @if (filled($encodedFormat)) data-format="{{ $encodedFormat }}" @endif>
        <g>
            <text
                {{
                    $attributes->merge([
                        'class' => 'text-xs text-zinc-500 dark:text-zinc-300',
                        'dominant-baseline' => 'central',
                        'fill' => 'currentColor',
                        'text-anchor' => $position === 'right' ? 'start' : 'end',
                        'dx' => $position === 'right' ? '1em' : '-1em',
                    ])
                }}
            ></text>
        </g>
    </template>
@endif
