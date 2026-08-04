Date + time selection with calendar and scrollable time list. Subcomponents include `panel`, `time-list`, and `footer`. Reuses `date-picker.button` for the trigger. Included in `@stencilScripts`.

```blade
<x-ui::datetime-picker name="scheduled_at" value="2026-07-29T14:30:00+00:00" />

<x-ui::datetime-picker name="scheduled_at" :shortcut="false">
    <x-ui::date-picker.button data-datetime-picker-trigger />
    <x-ui::datetime-picker.panel>
        <x-ui::calendar value="2026-07-29" data-datetime-picker-calendar />
        <x-ui::datetime-picker.time-list />
        <x-ui::datetime-picker.footer />
    </x-ui::datetime-picker.panel>
</x-ui::datetime-picker>
```

<br>
