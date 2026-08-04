@props([
    'command',
])

<div class="flex w-full flex-col gap-3 rounded-xl border border-zinc-200/80 bg-zinc-50 px-4 py-3 md:flex-row md:items-center md:justify-between md:gap-4 dark:border-zinc-800 dark:bg-zinc-900/60">
    <div class="min-w-0 flex-1">
        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Requires a JavaScript module</p>
        <p class="mt-0.5 text-sm text-zinc-600 dark:text-zinc-400">
            Run the install command to copy the widget script and patch your Vite entry.
        </p>
    </div>
    <div class="min-w-0 shrink-0 overflow-x-auto">
        <x-ui::code-block inline language="bash" :code="'php artisan '.$command" class="inline-block whitespace-nowrap" />
    </div>
</div>
