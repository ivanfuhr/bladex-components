@props([
    'command',
])

<div class="flex flex-col gap-2 rounded-xl border border-zinc-200/80 bg-zinc-50 px-4 py-3 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-800 dark:bg-zinc-900/60">
    <div class="min-w-0">
        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Requires a JavaScript module</p>
        <p class="mt-0.5 text-sm text-zinc-600 dark:text-zinc-400">
            Run the install command to copy the widget script and patch your Vite entry.
        </p>
    </div>
    <x-ui::code-block inline language="bash" :code="'php artisan '.$command" />
</div>
