@aware(['axis' => 'x'])

@if ($axis === 'x')
    <template data-chart-template="axis-line" data-axis-orientation="bottom">
        <line
            {{
                $attributes->merge([
                    'class' => 'text-zinc-300 dark:text-white/40',
                    'stroke-width' => '1',
                    'stroke' => 'currentColor',
                    'fill' => 'none',
                ])
            }}
        ></line>
    </template>
@else
    <template data-chart-template="axis-line" data-axis-orientation="left">
        <line
            {{
                $attributes->merge([
                    'class' => 'text-zinc-300 dark:text-white/40',
                    'stroke-width' => '1',
                    'stroke' => 'currentColor',
                    'fill' => 'none',
                ])
            }}
        ></line>
    </template>
@endif
