<template data-chart-template="cursor">
    <path
        {{
            $attributes->merge([
                'class' => 'text-zinc-500 dark:text-zinc-300',
                'data-cursor-type' => $type,
                'fill' => 'none',
                'stroke' => 'currentColor',
                'stroke-width' => '1',
                'stroke-dasharray' => '4,4',
            ])
        }}
    ></path>
</template>
