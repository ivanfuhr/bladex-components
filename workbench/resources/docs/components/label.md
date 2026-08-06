Accessible `<label>` with optional `badge` and `required` marker. Pairs with any control via `for` (see [shadcn Label](https://ui.shadcn.com/docs/components/aria/label) and [Flux label](https://fluxui.dev/components/field)).

```blade
<x-std::label for="email">Email</x-std::label>
<x-std::input name="email" id="email" type="email" placeholder="you@example.com" />

<x-std::label for="phone" badge="Optional">Phone</x-std::label>
<x-std::input name="phone" id="phone" placeholder="(555) 555-5555" />

<x-std::label for="password" badge="Required" :required="true">Password</x-std::label>
<x-std::input name="password" id="password" type="password" />
```

<br>
