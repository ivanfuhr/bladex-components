<template
    data-chart-template="bar"
    data-field="{{ $field }}"
    @if (filled($minHeight)) data-min-height="{{ $minHeight }}" @endif
    @if (filled($radius)) data-radius="{{ $radius }}" @endif
    @if (filled($width)) data-width="{{ $width }}" @endif
>
    <path
        {{
            $attributes->class('text-zinc-800 dark:text-zinc-100')->merge([
                'stroke' => 'none',
                'fill' => 'currentColor',
            ])
        }}
    ></path>
</template>
