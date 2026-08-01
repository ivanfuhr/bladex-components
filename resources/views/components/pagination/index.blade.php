@props([
    'paginator' => null,
])

@php
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;

    $hasPaginator = $paginator instanceof LengthAwarePaginator;
@endphp

<nav {{
    $attributes->class([
        'pagination',
        'mx-auto flex w-full justify-center',
    ])->merge([
        'role' => 'navigation',
        'aria-label' => 'pagination',
        'data-pagination' => true,
    ])
}}>
    @if ($hasPaginator)
        <x-stencil::pagination.content>
            <x-stencil::pagination.item>
                <x-stencil::pagination.previous
                    :href="$paginator->previousPageUrl() ?? '#'"
                    :disabled="$paginator->onFirstPage()"
                />
            </x-stencil::pagination.item>

            @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 1), min($paginator->lastPage(), $paginator->currentPage() + 1)) as $page => $url)
                <x-stencil::pagination.item>
                    <x-stencil::pagination.link :href="$url" :is-active="$page === $paginator->currentPage()">
                        {{ $page }}
                    </x-stencil::pagination.link>
                </x-stencil::pagination.item>
            @endforeach

            <x-stencil::pagination.item>
                <x-stencil::pagination.next
                    :href="$paginator->nextPageUrl() ?? '#'"
                    :disabled="! $paginator->hasMorePages()"
                />
            </x-stencil::pagination.item>
        </x-stencil::pagination.content>
    @else
        {{ $slot }}
    @endif
</nav>
