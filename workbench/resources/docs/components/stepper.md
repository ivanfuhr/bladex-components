Multi-step wizard indicator ([Filament Wizard](https://filamentphp.com/docs/3.x/forms/layout/wizard), [shadcn community steppers](https://github.com/francozeta/stepper)). Horizontal or vertical, with complete / current / upcoming states. Included in `@stdScripts`.

```blade
<x-std::stepper default-value="account">
    <x-std::stepper.list>
        <x-std::stepper.item value="account" :step="1">
            <x-std::stepper.trigger>
                <x-std::stepper.indicator />
                <x-std::stepper.label>
                    <x-std::stepper.title>Account</x-std::stepper.title>
                    <x-std::stepper.description>Profile details</x-std::stepper.description>
                </x-std::stepper.label>
            </x-std::stepper.trigger>
            <x-std::stepper.separator />
        </x-std::stepper.item>
        <x-std::stepper.item value="workspace" :step="2">
            <x-std::stepper.trigger>
                <x-std::stepper.indicator />
                <x-std::stepper.title>Workspace</x-std::stepper.title>
            </x-std::stepper.trigger>
        </x-std::stepper.item>
    </x-std::stepper.list>

    <x-std::stepper.content value="account">Account details</x-std::stepper.content>
    <x-std::stepper.content value="workspace">Workspace details</x-std::stepper.content>

    <x-std::stepper.navigation>
        <x-std::stepper.previous />
        <x-std::stepper.next />
    </x-std::stepper.navigation>
</x-std::stepper>
```

<br>
