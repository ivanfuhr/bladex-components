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
                <x-std::dropdown-menu align="start">
                    <x-std::dropdown-menu.trigger>
                        <button
                            type="button"
                            class="inline-flex h-11 max-w-full min-w-0 items-center gap-1.5 rounded-md px-1 text-sm transition-colors hover:text-zinc-950 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20"
                            aria-label="{{ __('Show breadcrumb trail') }}"
                        >
                            <x-std::icon
                                name="chevron-right"
                                class="size-3.5 shrink-0 text-zinc-400 dark:text-zinc-500"
                            />
                            <span class="truncate font-normal text-zinc-950 dark:text-zinc-50">
                                {{ $current['label'] }}
                            </span>
                            <x-std::icon
                                name="chevron-down"
                                class="size-3.5 shrink-0 text-zinc-400 dark:text-zinc-500"
                            />
                        </button>
                    </x-std::dropdown-menu.trigger>
                    <x-std::dropdown-menu.content class="min-w-48">
                        @foreach ($ancestors as $ancestor)
                            <x-std::dropdown-menu.item :href="$ancestor['href']">
                                {{ $ancestor['label'] }}
                            </x-std::dropdown-menu.item>
                        @endforeach
                        <x-std::dropdown-menu.separator />
                        <x-std::dropdown-menu.label>{{ $current['label'] }}</x-std::dropdown-menu.label>
                    </x-std::dropdown-menu.content>
                </x-std::dropdown-menu>
            </div>
        @else
            <p class="truncate px-1 text-sm font-normal text-zinc-950 md:hidden dark:text-zinc-50">
                {{ $current['label'] }}
            </p>
        @endif

        <x-std::breadcrumb class="hidden min-w-0 md:block">
            <x-std::breadcrumb.list>
                @foreach ($trail as $item)
                    @if (! $loop->last)
                        <x-std::breadcrumb.item>
                            @if ($item['href'])
                                <x-std::breadcrumb.link :href="$item['href']">
                                    {{ $item['label'] }}</x-std::breadcrumb.link>
                            @else
                                <x-std::breadcrumb.page>{{ $item['label'] }}</x-std::breadcrumb.page>
                            @endif
                        </x-std::breadcrumb.item>
                        <x-std::breadcrumb.separator />
                    @else
                        <x-std::breadcrumb.item class="min-w-0 overflow-hidden">
                            <x-std::breadcrumb.page>{{ $item['label'] }}</x-std::breadcrumb.page>
                        </x-std::breadcrumb.item>
                    @endif
                @endforeach
            </x-std::breadcrumb.list>
        </x-std::breadcrumb>
    </div>
@endif
