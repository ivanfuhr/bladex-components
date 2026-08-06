Native checkbox for forms and multi-select ([Flux checkbox](https://fluxui.dev/docs)).

```blade
<x-std::field name="a" orientation="inline">
    <x-std::checkbox name="a" :checked="true" />
    <x-std::field.label>Default size</x-std::field.label>
</x-std::field>
<x-std::field name="b" orientation="inline">
    <x-std::checkbox name="b" size="sm" :checked="true" />
    <x-std::field.label>Small</x-std::field.label>
</x-std::field>
<x-std::field orientation="inline">
    <x-std::checkbox name="c" :invalid="true" />
    <x-std::field.label>Invalid</x-std::field.label>
</x-std::field>
<x-std::field orientation="inline">
    <x-std::checkbox name="d" disabled />
    <x-std::field.label>Disabled</x-std::field.label>
</x-std::field>
```

<br>
