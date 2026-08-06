User image or initials ([shadcn Avatar](https://ui.shadcn.com/docs/components/avatar), [Flux avatar](https://fluxui.dev/components/avatar)). Subcomponents include `image`, `fallback`, and `group`. Included in `@stdScripts`.

```blade
<x-std::avatar src="https://example.com/me.jpg" name="Caleb Porzio" circle size="lg" />
<x-std::avatar name="Ada Lovelace" color="violet" />

<x-std::avatar.group>
    <x-std::avatar name="One" circle />
    <x-std::avatar name="Two" circle />
</x-std::avatar.group>
```

<br>
