<nav {{
    $attributes->class([
        'pagination',
        'mx-auto flex w-full justify-center',
    ])->merge([
        'aria-label' => __('Pagination'),
        'data-pagination' => true,
    ])
}}>
    @if ($hasPaginator)
        <x-std::pagination.content>
            <x-std::pagination.item>
                <x-std::pagination.previous
                    :href="$paginator->previousPageUrl() ?? '#'"
                    :disabled="$paginator->onFirstPage()"
                />
            </x-std::pagination.item>

            @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 1), min($paginator->lastPage(), $paginator->currentPage() + 1)) as $page => $url)
                <x-std::pagination.item>
                    <x-std::pagination.link :href="$url" :is-active="$page === $paginator->currentPage()">
                        {{ $page }}
                    </x-std::pagination.link>
                </x-std::pagination.item>
            @endforeach

            <x-std::pagination.item>
                <x-std::pagination.next
                    :href="$paginator->nextPageUrl() ?? '#'"
                    :disabled="! $paginator->hasMorePages()"
                />
            </x-std::pagination.item>
        </x-std::pagination.content>
    @else
        {{ $slot }}
    @endif
</nav>
