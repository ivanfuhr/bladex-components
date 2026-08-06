<x-std::pagination.link
    :href="$href"
    :disabled="$disabled"
    {{ $attributes->class(['gap-1 px-2.5 w-auto min-h-11 min-w-11'])->merge(['aria-label' => __('Previous')]) }}
>
    <x-std::icon name="chevron-left" class="size-4" />
    <span class="hidden sm:inline">{{ $text ?? __('Previous') }}</span>
</x-std::pagination.link>
