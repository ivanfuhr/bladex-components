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
        <x-ui::pagination.content>
            <x-ui::pagination.item>
                <x-ui::pagination.previous
                    :href="$paginator->previousPageUrl() ?? '#'"
                    :disabled="$paginator->onFirstPage()"
                />
            </x-ui::pagination.item>

            @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 1), min($paginator->lastPage(), $paginator->currentPage() + 1)) as $page => $url)
                <x-ui::pagination.item>
                    <x-ui::pagination.link :href="$url" :is-active="$page === $paginator->currentPage()">
                        {{ $page }}
                    </x-ui::pagination.link>
                </x-ui::pagination.item>
            @endforeach

            <x-ui::pagination.item>
                <x-ui::pagination.next
                    :href="$paginator->nextPageUrl() ?? '#'"
                    :disabled="! $paginator->hasMorePages()"
                />
            </x-ui::pagination.item>
        </x-ui::pagination.content>
    @else
        {{ $slot }}
    @endif
</nav>
