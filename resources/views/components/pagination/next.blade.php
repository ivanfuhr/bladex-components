@props([
    'href' => '#',
    'disabled' => false,
    'text' => null,
])

<x-stencil::pagination.link
    :href="$href"
    :disabled="$disabled"
    {{ $attributes->class(['gap-1 px-2.5 w-auto min-w-9'])->merge(['aria-label' => __('stencil::messages.pagination_next')]) }}
>
    <span class="hidden sm:inline">{{ $text ?? __('stencil::messages.pagination_next') }}</span>
    <x-stencil::icon name="chevron-right" class="size-4" />
</x-stencil::pagination.link>
