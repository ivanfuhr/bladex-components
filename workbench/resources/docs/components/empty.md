Empty state for lists, tables, and first-run screens ([shadcn Empty](https://ui.shadcn.com/docs/components/empty), [Filament empty-state](https://filamentphp.com/docs/5.x/components/empty-state)). Compose `header` → `media` / `title` / `description`, then `content` for actions. Media `variant="icon"` wraps Lucide icons; pass `icon="…"` or slot custom media. Add `class="border"` for an outlined stage.

```blade
<x-ui::empty class="border">
    <x-ui::empty.header>
        <x-ui::empty.media variant="icon" icon="file" />
        <x-ui::empty.title>No projects yet</x-ui::empty.title>
        <x-ui::empty.description>
            You haven't created any projects yet. Get started by creating your first project.
        </x-ui::empty.description>
    </x-ui::empty.header>
    <x-ui::empty.content>
        <x-ui::button variant="primary">Create project</x-ui::button>
    </x-ui::empty.content>
</x-ui::empty>
```

<br>
