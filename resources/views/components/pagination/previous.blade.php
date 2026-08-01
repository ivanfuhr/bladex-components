@props([
    'href' => '#',
    'disabled' => false,
    'text' => null,
])

<x-stencil::pagination.link
    :href="$href"
    :disabled="$disabled"
    {{ $attributes->class(['gap-1 px-2.5 w-auto min-w-9'])->merge(['aria-label' => __('stencil::messages.pagination_previous')]) }}
>
    <x-stencil::icon name="chevron-left" class="size-4" />
    <span class="hidden sm:inline">{{ $text ?? __('stencil::messages.pagination_previous') }}</span>
</x-stencil::pagination.link>
