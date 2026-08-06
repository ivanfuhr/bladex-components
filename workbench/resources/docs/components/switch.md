`role="switch"` toggle for settings-style UI ([Flux switch](https://fluxui.dev/components/switch)). Prefer `checkbox` inside classic form posts.

```blade
<x-std::field name="n1" orientation="inline">
    <div class="flex min-w-0 flex-1 flex-col gap-1">
        <x-std::field.label>Notifications</x-std::field.label>
    </div>
    <x-std::switch name="n1" :checked="true" />
</x-std::field>

<x-std::field name="n2" orientation="inline">
    <div class="flex min-w-0 flex-1 flex-col gap-1">
        <x-std::field.label>Notifications</x-std::field.label>
    </div>
    <x-std::switch name="n2" size="sm" :checked="true" />
</x-std::field>

<x-std::switch name="n3" />
```

<br>
