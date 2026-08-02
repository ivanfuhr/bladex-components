@aware(['axis' => 'x'])

@if ($axis === 'x')
    <template data-chart-template="grid-line" data-grid-type="horizontal">
        <line
            {{
                $attributes->merge([
                    'class' => 'text-zinc-200/50 dark:text-white/15',
                    'stroke' => 'currentColor',
                    'stroke-width' => '1',
                ])
            }}
        ></line>
    </template>
@else
    <template data-chart-template="grid-line" data-grid-type="vertical">
        <line
            {{
                $attributes->merge([
                    'class' => 'text-zinc-200/50 dark:text-white/15',
                    'stroke' => 'currentColor',
                    'stroke-width' => '1',
                ])
            }}
        ></line>
    </template>
@endif
