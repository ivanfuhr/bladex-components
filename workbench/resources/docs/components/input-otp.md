Accessible one-time password / PIN input with labeled slots, paste support, and arrow/backspace navigation. Subcomponents include `group`, `slot`, and `separator`. Included in `@stdScripts`. A hidden input carries the combined value for form submit (`name`).

Default `shortcut` renders slots for `length` (default `6`). Even lengths ≥ 4 include a middle separator unless you set `:separated="false"`. Use `mode="numeric"` (default) or `mode="alphanumeric"`. Set `:shortcut="false"` for full composition. Works inside `field` (inherits `invalid` / Laravel `$errors`).

```blade
<x-std::input-otp name="code" />

<x-std::input-otp name="pin" :length="4" />

<x-std::input-otp name="token" mode="alphanumeric" :separated="false" />

<x-std::input-otp name="bad" invalid />
<x-std::input-otp name="off" disabled />

{{-- Full composition --}}
<x-std::input-otp name="code" :length="6" :shortcut="false">
    <x-std::input-otp.group>
        <x-std::input-otp.slot :index="0" />
        <x-std::input-otp.slot :index="1" />
        <x-std::input-otp.slot :index="2" />
    </x-std::input-otp.group>
    <x-std::input-otp.separator />
    <x-std::input-otp.group>
        <x-std::input-otp.slot :index="3" />
        <x-std::input-otp.slot :index="4" />
        <x-std::input-otp.slot :index="5" />
    </x-std::input-otp.group>
</x-std::input-otp>

<x-std::field name="code">
    <x-std::field.label>Verification code</x-std::field.label>
    <x-std::input-otp name="code" />
    <x-std::field.errors name="code" />
</x-std::field>
```

<br>
