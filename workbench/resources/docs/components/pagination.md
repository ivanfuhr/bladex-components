Page controls ([shadcn Pagination](https://ui.shadcn.com/docs/components/pagination)). Compose manually or pass a Laravel `LengthAwarePaginator`.

```blade
<x-ui::pagination :paginator="$orders" />

<x-ui::pagination>
    <x-ui::pagination.content>
        <x-ui::pagination.item>
            <x-ui::pagination.previous href="?page=1" />
        </x-ui::pagination.item>
        <x-ui::pagination.item>
            <x-ui::pagination.link href="?page=2" :is-active="true">2</x-ui::pagination.link>
        </x-ui::pagination.item>
        <x-ui::pagination.item>
            <x-ui::pagination.next href="?page=3" />
        </x-ui::pagination.item>
    </x-ui::pagination.content>
</x-ui::pagination>
```

<br>
