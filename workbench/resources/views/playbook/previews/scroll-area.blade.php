@php
    $type = (string) ($state['type'] ?? 'always');
    $horizontal = (bool) ($state['horizontal'] ?? false);

    $tags = [
        'v1.2.0',
        'beta',
        'react',
        'vue',
        'svelte',
        'alpine',
        'laravel',
        'livewire',
        'inertia',
        'tailwind',
        'vite',
        'php',
        'typescript',
        'accessibility',
        'design-system',
        'components',
        'forms',
        'overlays',
        'navigation',
        'charts',
        'tables',
        'datetime',
        'icons',
        'themes',
        'dark-mode',
        'keyboard',
        'focus-ring',
        'rtl',
        'i18n',
        'a11y',
    ];
@endphp

<div class="w-full max-w-sm space-y-3">
    <x-ui::text size="sm" variant="subtle">Scroll inside the panel — themed overlay bars follow the content.</x-ui::text>

    <x-ui::scroll-area
        class="h-56 rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950"
        :type="$type"
        :horizontal="$horizontal"
        aria-label="Package tags"
    >
        @if ($horizontal)
            <div class="flex w-max gap-2 p-4">
                @foreach ($tags as $tag)
                    <span class="inline-flex shrink-0 rounded-md border border-zinc-200 bg-zinc-50 px-2.5 py-1 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300">
                        {{ $tag }}
                    </span>
                @endforeach
            </div>
        @else
            <div class="space-y-2 p-4">
                @foreach ($tags as $tag)
                    <div class="rounded-md border border-zinc-200 px-3 py-2 text-sm text-zinc-800 dark:border-zinc-700 dark:text-zinc-200">
                        {{ $tag }}
                    </div>
                @endforeach
            </div>
        @endif
    </x-ui::scroll-area>
</div>
