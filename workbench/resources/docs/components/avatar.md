User image or initials ([shadcn Avatar](https://ui.shadcn.com/docs/components/avatar), [Flux avatar](https://fluxui.dev/components/avatar)). Subcomponents include `image`, `fallback`, and `group`. Included in `@stencilScripts`.

```blade
<x-ui::avatar src="https://example.com/me.jpg" name="Caleb Porzio" circle size="lg" />
<x-ui::avatar name="Ada Lovelace" color="violet" />

<x-ui::avatar.group>
    <x-ui::avatar name="One" circle />
    <x-ui::avatar name="Two" circle />
</x-ui::avatar.group>
```

<br>
