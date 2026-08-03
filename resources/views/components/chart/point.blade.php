<template data-chart-template="point" data-field="{{ $field }}">
    <circle
        {{
            $attributes->class('text-zinc-800 dark:text-zinc-100 stroke-white dark:stroke-zinc-900')->merge([
                'r' => '4',
                'fill' => 'currentColor',
                'stroke-width' => '1',
            ])
        }}
    ></circle>
</template>
