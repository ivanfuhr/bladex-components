<template data-chart-template="tooltip">
    <div {{
        $attributes->class([
            'pointer-events-none absolute z-10 flex flex-col overflow-hidden rounded-lg border border-zinc-200 bg-white opacity-0 shadow-lg transition-opacity motion-reduce:transition-none dark:border-zinc-500 dark:bg-zinc-700',
            'data-active:opacity-100',
        ])->merge([
            'data-chart-tooltip' => true,
            'role' => 'status',
            'aria-live' => 'off',
        ])
    }}>
        {{ $slot }}
    </div>
</template>
