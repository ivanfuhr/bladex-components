Accessible one-time password / PIN input with labeled slots, paste support, and arrow/backspace navigation. Subcomponents include `group`, `slot`, and `separator`. Included in `@stencilScripts`. A hidden input carries the combined value for form submit (`name`).

Default `shortcut` renders slots for `length` (default `6`). Even lengths ≥ 4 include a middle separator unless you set `:separated="false"`. Use `mode="numeric"` (default) or `mode="alphanumeric"`. Set `:shortcut="false"` for full composition. Works inside `field` (inherits `invalid` / Laravel `$errors`).

```blade
<x-ui::input-otp name="code" />

<x-ui::input-otp name="pin" :length="4" />

<x-ui::input-otp name="token" mode="alphanumeric" :separated="false" />

<x-ui::input-otp name="bad" invalid />
<x-ui::input-otp name="off" disabled />

{{-- Full composition --}}
<x-ui::input-otp name="code" :length="6" :shortcut="false">
    <x-ui::input-otp.group>
        <x-ui::input-otp.slot :index="0" />
        <x-ui::input-otp.slot :index="1" />
        <x-ui::input-otp.slot :index="2" />
    </x-ui::input-otp.group>
    <x-ui::input-otp.separator />
    <x-ui::input-otp.group>
        <x-ui::input-otp.slot :index="3" />
        <x-ui::input-otp.slot :index="4" />
        <x-ui::input-otp.slot :index="5" />
    </x-ui::input-otp.group>
</x-ui::input-otp>

<x-ui::field name="code">
    <x-ui::field.label>Verification code</x-ui::field.label>
    <x-ui::input-otp name="code" />
    <x-ui::field.errors name="code" />
</x-ui::field>
```

<br>
