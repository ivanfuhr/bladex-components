Empty state for lists, tables, and first-run screens ([shadcn Empty](https://ui.shadcn.com/docs/components/empty), [Filament empty-state](https://filamentphp.com/docs/5.x/components/empty-state)). Compose `header` → `media` / `title` / `description`, then `content` for actions. Media `variant="icon"` wraps Lucide icons; pass `icon="…"` or slot custom media. Add `class="border"` for an outlined stage.

```blade
<x-std::empty class="border">
    <x-std::empty.header>
        <x-std::empty.media variant="icon" icon="file" />
        <x-std::empty.title>No projects yet</x-std::empty.title>
        <x-std::empty.description>
            You haven't created any projects yet. Get started by creating your first project.
        </x-std::empty.description>
    </x-std::empty.header>
    <x-std::empty.content>
        <x-std::button variant="primary">Create project</x-std::button>
    </x-std::empty.content>
</x-std::empty>
```

<br>
