Multi-line control with the same invalid/disabled behavior as `input` ([shadcn Textarea](https://ui.shadcn.com/docs/components/base/textarea)).

```blade
<x-std::textarea name="bio" placeholder="About you…" rows="3" />
<x-std::textarea name="bio-sm" size="sm" placeholder="About you…" rows="3" />
<x-std::textarea name="bio-invalid" :invalid="true" value="Too short" />
<x-std::textarea name="bio-disabled" disabled placeholder="Disabled" />
```

<br>
