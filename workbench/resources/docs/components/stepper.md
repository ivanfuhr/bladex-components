Multi-step wizard indicator ([Filament Wizard](https://filamentphp.com/docs/3.x/forms/layout/wizard), [shadcn community steppers](https://github.com/francozeta/stepper)). Horizontal or vertical, with complete / current / upcoming states. Included in `@stencilScripts`.

```blade
<x-ui::stepper default-value="account">
    <x-ui::stepper.list>
        <x-ui::stepper.item value="account" :step="1">
            <x-ui::stepper.trigger>
                <x-ui::stepper.indicator />
                <x-ui::stepper.label>
                    <x-ui::stepper.title>Account</x-ui::stepper.title>
                    <x-ui::stepper.description>Profile details</x-ui::stepper.description>
                </x-ui::stepper.label>
            </x-ui::stepper.trigger>
            <x-ui::stepper.separator />
        </x-ui::stepper.item>
        <x-ui::stepper.item value="workspace" :step="2">
            <x-ui::stepper.trigger>
                <x-ui::stepper.indicator />
                <x-ui::stepper.title>Workspace</x-ui::stepper.title>
            </x-ui::stepper.trigger>
        </x-ui::stepper.item>
    </x-ui::stepper.list>

    <x-ui::stepper.content value="account">Account details</x-ui::stepper.content>
    <x-ui::stepper.content value="workspace">Workspace details</x-ui::stepper.content>

    <x-ui::stepper.navigation>
        <x-ui::stepper.previous />
        <x-ui::stepper.next />
    </x-ui::stepper.navigation>
</x-ui::stepper>
```

<br>
