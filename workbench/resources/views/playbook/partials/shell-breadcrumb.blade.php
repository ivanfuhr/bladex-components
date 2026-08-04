@props([
    /** @var list<array{label: string, href?: string|null, current?: bool}> */
    'items' => [],
])

@php
    $trail = collect($items)
        ->map(fn (array $item) => [
            'label' => (string) ($item['label'] ?? ''),
            'href' => filled($item['href'] ?? null) ? (string) $item['href'] : null,
            'current' => (bool) ($item['current'] ?? false),
        ])
        ->filter(fn (array $item) => $item['label'] !== '')
        ->values();

    $current = $trail->firstWhere('current', true) ?? $trail->last();
    $ancestors = $trail->reject(fn (array $item) => $item['current'])->values();
    $hasAncestors = $ancestors->isNotEmpty();
@endphp

@if ($current)
    <div {{ $attributes->class(['min-w-0 flex-1 overflow-hidden']) }}>
        @if ($hasAncestors)
            <div class="md:hidden">
                <x-ui::dropdown-menu align="start">
                    <x-ui::dropdown-menu.trigger>
                        <button
                            type="button"
                            class="inline-flex h-11 max-w-full min-w-0 items-center gap-1.5 rounded-md px-1 text-sm transition-colors hover:text-zinc-950 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20"
                            aria-label="{{ __('Show breadcrumb trail') }}"
                        >
                            <x-ui::icon
                                name="chevron-right"
                                class="size-3.5 shrink-0 text-zinc-400 dark:text-zinc-500"
                            />
                            <span class="truncate font-normal text-zinc-950 dark:text-zinc-50">
                                {{ $current['label'] }}
                            </span>
                            <x-ui::icon
                                name="chevron-down"
                                class="size-3.5 shrink-0 text-zinc-400 dark:text-zinc-500"
                            />
                        </button>
                    </x-ui::dropdown-menu.trigger>
                    <x-ui::dropdown-menu.content class="min-w-48">
                        @foreach ($ancestors as $ancestor)
                            <x-ui::dropdown-menu.item :href="$ancestor['href']">
                                {{ $ancestor['label'] }}
                            </x-ui::dropdown-menu.item>
                        @endforeach
                        <x-ui::dropdown-menu.separator />
                        <x-ui::dropdown-menu.label>{{ $current['label'] }}</x-ui::dropdown-menu.label>
                    </x-ui::dropdown-menu.content>
                </x-ui::dropdown-menu>
            </div>
        @else
            <p class="truncate px-1 text-sm font-normal text-zinc-950 md:hidden dark:text-zinc-50">
                {{ $current['label'] }}
            </p>
        @endif

        <x-ui::breadcrumb class="hidden min-w-0 md:block">
            <x-ui::breadcrumb.list>
                @foreach ($trail as $item)
                    @if (! $loop->last)
                        <x-ui::breadcrumb.item>
                            @if ($item['href'])
                                <x-ui::breadcrumb.link :href="$item['href']">{{ $item['label'] }}</x-ui::breadcrumb.link>
                            @else
                                <x-ui::breadcrumb.page>{{ $item['label'] }}</x-ui::breadcrumb.page>
                            @endif
                        </x-ui::breadcrumb.item>
                        <x-ui::breadcrumb.separator />
                    @else
                        <x-ui::breadcrumb.item class="min-w-0 overflow-hidden">
                            <x-ui::breadcrumb.page>{{ $item['label'] }}</x-ui::breadcrumb.page>
                        </x-ui::breadcrumb.item>
                    @endif
                @endforeach
            </x-ui::breadcrumb.list>
        </x-ui::breadcrumb>
    </div>
@endif
