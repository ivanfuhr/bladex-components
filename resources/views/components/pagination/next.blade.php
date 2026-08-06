<x-std::pagination.link
    :href="$href"
    :disabled="$disabled"
    {{ $attributes->class(['gap-1 px-2.5 w-auto min-h-11 min-w-11'])->merge(['aria-label' => __('Next')]) }}
>
    <span class="hidden sm:inline">{{ $text ?? __('Next') }}</span>
    <x-std::icon name="chevron-right" class="size-4" />
</x-std::pagination.link>
