<template data-chart-template="zero-line">
    <line
        {{
            $attributes->merge([
                'class' => 'text-zinc-400 dark:text-zinc-500',
                'data-zero-orientation' => 'left',
                'stroke-width' => '1',
                'stroke' => 'currentColor',
                'fill' => 'none',
            ])
        }}
    ></line>
</template>
