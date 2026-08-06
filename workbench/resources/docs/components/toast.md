Transient notifications / Sonner-style toasts ([shadcn Toast](https://ui.shadcn.com/docs/components/toast)). Mount `toast.provider` once, then render toasts or call `window.StdComponents.toast({ title, description, variant })`.

```blade
<x-std::toast.provider>
    <x-std::toast variant="success" title="Saved" description="Your changes were saved." />
</x-std::toast.provider>
```

<br>
