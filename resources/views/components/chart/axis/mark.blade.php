@aware(['axis' => 'x', 'position' => null])

@if ($axis === 'x')
    <template data-chart-template="tick-mark" data-tick-orientation="{{ $position === 'top' ? 'top' : 'bottom' }}">
        <g>
            <line
                {{
                    $attributes->merge([
                        'class' => 'stroke-zinc-300 dark:stroke-zinc-600',
                        'stroke' => 'currentColor',
                        'stroke-width' => '1',
                        'fill' => 'none',
                        'y1' => '0',
                        'y2' => '6',
                    ])
                }}
            ></line>
        </g>
    </template>
@else
    <template data-chart-template="tick-mark" data-tick-orientation="{{ $position === 'right' ? 'right' : 'left' }}">
        <g>
            <line
                {{
                    $attributes->merge([
                        'class' => 'stroke-zinc-300 dark:stroke-zinc-600',
                        'stroke' => 'currentColor',
                        'stroke-width' => '1',
                        'fill' => 'none',
                        'x1' => $position === 'right' ? '0' : '-6',
                        'x2' => $position === 'right' ? '6' : '0',
                    ])
                }}
            ></line>
        </g>
    </template>
@endif
