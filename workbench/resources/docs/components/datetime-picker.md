Date + time selection with calendar and scrollable time list. Subcomponents include `panel`, `time-list`, and `footer`. Reuses `date-picker.button` for the trigger. Included in `@stdScripts`.

```blade
<x-std::datetime-picker name="scheduled_at" value="2026-07-29T14:30:00+00:00" />

<x-std::datetime-picker name="scheduled_at" :shortcut="false">
    <x-std::date-picker.button data-datetime-picker-trigger />
    <x-std::datetime-picker.panel>
        <x-std::calendar value="2026-07-29" data-datetime-picker-calendar />
        <x-std::datetime-picker.time-list />
        <x-std::datetime-picker.footer />
    </x-std::datetime-picker.panel>
</x-std::datetime-picker>
```

<br>
