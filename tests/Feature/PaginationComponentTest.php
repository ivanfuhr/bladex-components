<?php

declare(strict_types=1);

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Blade;

it('renders compound pagination controls', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::pagination>
            <x-std::pagination.content>
                <x-std::pagination.item>
                    <x-std::pagination.previous href="?page=1" />
                </x-std::pagination.item>
                <x-std::pagination.item>
                    <x-std::pagination.link href="?page=2" :is-active="true">2</x-std::pagination.link>
                </x-std::pagination.item>
                <x-std::pagination.item>
                    <x-std::pagination.ellipsis />
                </x-std::pagination.item>
                <x-std::pagination.item>
                    <x-std::pagination.next href="?page=3" />
                </x-std::pagination.item>
            </x-std::pagination.content>
        </x-std::pagination>
    BLADE);

    expect($html)
        ->toContain('data-pagination')
        ->toContain('aria-label="Pagination"')
        ->toContain('data-active="true"')
        ->toContain('data-pagination-ellipsis')
        ->toContain('?page=3');
});

it('renders pagination from a laravel paginator', function () {
    $paginator = new LengthAwarePaginator(
        items: range(1, 5),
        total: 20,
        perPage: 5,
        currentPage: 2,
        options: ['path' => '/orders'],
    );

    $html = Blade::render('<x-std::pagination :paginator="$paginator" />', [
        'paginator' => $paginator,
    ]);

    expect($html)
        ->toContain('data-pagination')
        ->toContain('aria-current="page"')
        ->toContain('data-active="true"')
        ->toContain('/orders?page=2');
});
