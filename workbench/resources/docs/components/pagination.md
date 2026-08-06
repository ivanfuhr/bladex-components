Page controls ([shadcn Pagination](https://ui.shadcn.com/docs/components/pagination)). Compose manually or pass a Laravel `LengthAwarePaginator`.

```blade
<x-std::pagination :paginator="$orders" />

<x-std::pagination>
    <x-std::pagination.content>
        <x-std::pagination.item>
            <x-std::pagination.previous href="?page=1" />
        </x-std::pagination.item>
        <x-std::pagination.item>
            <x-std::pagination.link href="?page=2" :is-active="true">2</x-std::pagination.link>
        </x-std::pagination.item>
        <x-std::pagination.item>
            <x-std::pagination.next href="?page=3" />
        </x-std::pagination.item>
    </x-std::pagination.content>
</x-std::pagination>
```

<br>
