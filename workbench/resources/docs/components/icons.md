On-demand [Lucide](https://lucide.dev/icons/) icons — `outline` (16px), `mini` (20px), and `micro` (12px) variants. The built-in loading spinner ships with the package. Use `php artisan std:icon` to publish additional Lucide icons.

```bash
php artisan std:icon search
```

```blade
<x-std::icon.loading class="size-4" />
<x-std::icon.loading class="size-5" />
<x-std::icon.loading class="size-3" />

<x-std::input name="search" placeholder="Search…">
    <x-slot:leading>
        <x-std::icon.loading />
    </x-slot:leading>
</x-std::input>

<x-std::button variant="primary">
    <x-slot:leading>
        <x-std::icon.loading class="animate-spin" />
    </x-slot:leading>
    Saving…
</x-std::button>
```

<br>
