Transient notifications / Sonner-style toasts ([shadcn Toast](https://ui.shadcn.com/docs/components/toast)). Mount `toast.provider` once, then render toasts or call `window.Stencil.toast({ title, description, variant })`.

```blade
<x-ui::toast.provider>
    <x-ui::toast variant="success" title="Saved" description="Your changes were saved." />
</x-ui::toast.provider>
```

<br>
