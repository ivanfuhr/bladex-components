Application logo and name for headers and navbars ([Flux brand](https://fluxui.dev/components/brand)). Props include `name`, `logo`, `logo-dark` / `logoDark`, `alt`, and `href` (default `/`). Use the `logo` slot for custom markup such as monograms or icons.

```blade
<x-std::header>
    <x-std::brand href="/" name="Acme Inc." logo="/logo.svg" alt="Acme" />

    <x-std::brand href="/" name="Launchpad">
        <x-slot:logo>
            <span class="text-xs font-bold">A</span>
        </x-slot:logo>
    </x-std::brand>
</x-std::header>
```

<br>
