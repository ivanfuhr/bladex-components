`radio.group` + `radio` items for single-choice fields ([shadcn Radio Group](https://ui.shadcn.com/docs)).

```blade
<x-std::radio.group name="plan" legend="Plan">
    <x-std::radio value="free">Free</x-std::radio>
    <x-std::radio value="pro" :checked="true">Pro</x-std::radio>
    <x-std::radio value="team">Team</x-std::radio>
</x-std::radio.group>
```

<br>
