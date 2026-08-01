<div align="center">

<a href="#table-of-contents">
  <img src="docs/images/banner.png" alt="Stencil — the modern component system for Laravel Blade" />
</a>

**Composable Blade primitives for Laravel — registry CLI and owned `x-ui::*` components.**

<p>
    <a href="https://packagist.org/packages/ivanfuhr/stencil"><img src="https://img.shields.io/packagist/v/ivanfuhr/stencil.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://packagist.org/packages/ivanfuhr/stencil"><img src="https://img.shields.io/packagist/php-v/ivanfuhr/stencil.svg?style=flat-square" alt="PHP from Packagist"></a>
    <a href="https://packagist.org/packages/ivanfuhr/stencil"><img src="https://badge.laravel.cloud/badge/ivanfuhr/stencil?style=flat" alt="Laravel versions"></a>
    <a href="https://github.com/ivanfuhr/stencil/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/ivanfuhr/stencil/tests.yml?branch=main&label=Tests&style=flat-square"></a>
    <a href="https://packagist.org/packages/ivanfuhr/stencil"><img src="https://img.shields.io/packagist/dt/ivanfuhr/stencil.svg?style=flat-square" alt="Total Downloads"></a>
</p>

</div>

<br>

<h2 id="table-of-contents">📑 Table of contents</h2>

| 🧩 **Components** | 📖 **Guide** | 🛠 **Project** |
| :--- | :--- | :--- |
| [Button](#button) · [Input](#input) · [Label](#label) · [Field](#field) · [Textarea](#textarea) · [Checkbox](#checkbox) · [Radio](#radio) · [Switch](#switch) · [Select](#select) · [Dialog](#dialog) · [Accordion](#accordion) · [Collapsible](#collapsible) · [Avatar](#avatar) · [Badge](#badge) · [Breadcrumb](#breadcrumb) · [Card](#card) · [Dropdown Menu](#dropdown-menu) · [Separator](#separator) · [Skeleton](#skeleton) · [Tabs](#tabs) · [Tooltip](#tooltip) · [Toast](#toast) · [Progress](#progress) · [Alert](#alert) · [Table](#table) · [Typography](#typography) · [Icons](#icons) | [Installation](#installation) · [Usage](#usage) · [Registry CLI](#registry-cli) · [Tailwind](#tailwind-css) · [Playbook](#development) | [Changelog](CHANGELOG.md) · [Contributing](.github/CONTRIBUTING.md) · [Security](.github/SECURITY.md) · [License](LICENSE.md) |

<br>

Copy only what you need with `stencil:add`, use `x-ui::*` in your app, and keep Tailwind v4 + class-based dark mode aligned with the design system.

Follow [Installation](#installation) and [Usage](#usage), then use the component previews further down once items are installed.

---

## Installation

```bash
composer require --dev ivanfuhr/stencil
```

The package is a **development dependency** (registry CLI). Run `stencil:init` and `stencil:add` to copy components into your app under `resources/views/ui` and `app/Support/Stencil`. Commit those files so production can run `composer install --no-dev` without the package.

Optional config publish:

```bash
php artisan vendor:publish --tag=stencil-config
```

<br>

## Usage

Initialize the project, browse the registry, then install only what you need. `stencil:add` resolves **`registryDependencies`** automatically (for example, `input` also installs `input-group`, `field`, and `text`) and installs declared **`iconDependencies`** as Lucide stubs (for example, `select` pulls in `chevron-down`, `check`, and `x`).

```bash
php artisan stencil:init
php artisan stencil:list
php artisan stencil:add input button select
```

`stencil:init` scaffolds `stencil.json`, `stencil.lock`, Tailwind integration (`resources/css/stencil.css` + import in `app.css`), support classes, `<x-ui::fonts />`, and registers `App\Providers\StencilUiServiceProvider` in `bootstrap/providers.php` when that file exists.

Use the owned Blade namespace in your app:

```blade
<x-ui::input name="email" />
```

**Registry UI items:** `accordion`, `alert`, `avatar`, `badge`, `breadcrumb`, `button`, `card`, `checkbox`, `collapsible`, `combobox`, `dialog`, `dropdown-menu`, `field`, `file-upload`, `heading`, `icon`, `input`, `input-group`, `input-otp`, `label`, `pagination`, `popover`, `progress`, `radio`, `select`, `separator`, `skeleton`, `slider`, `switch`, `table`, `tabs`, `text`, `textarea`, `toast`, `tooltip`. Lower-level pieces such as `field`, `input-group`, `label`, and `icon` are usually installed transitively. Components that use Lucide glyphs also install the required icon stubs during `stencil:add`; use `stencil:icon {name}` for any extra icons (see [Icons](#icons)).

### Registry CLI

<h3 id="registry-cli"></h3>

| Command | Description |
| --- | --- |
| `stencil:init` | Create `stencil.json`, scaffold owned support/CSS, and `stencil.lock` |
| `stencil:add {names}` | Install from the registry (includes dependencies) |
| `stencil:update {name?}` | Refresh installed files |
| `stencil:remove {names}` | Remove installed components |
| `stencil:list` | List registry items (`--installed`, `--all`) |
| `stencil:icon {names}` | Import Lucide icon stubs into `resources/views/ui/icons` |

### Tailwind CSS

<h3 id="tailwind-css"></h3>

Owned UI is scanned from `resources/views` and `app/Support/Stencil` via `resources/css/stencil.css`, with class-based dark mode (`.dark` on `<html>`).

```css
@import "tailwindcss";

/* stencil-start */
@import "./stencil.css";
/* stencil-end */
```

With `APP_DEBUG=true` and the package still installed, missing integration throws a clear exception (disable via `stencil.validate_tailwind_integration` in config). Default registry URL: `package://registry.json` (overridable in `stencil.json`).

<br>

---

Component previews match your GitHub theme via `<picture>` (`prefers-color-scheme`).

<br>

## Button

Variants: `outline`, `primary`, `secondary`, `danger`, `ghost`, `subtle`, `link` — sizes `xs`–`lg`, icon mode (`square`), and `leading` / `trailing` slots.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/buttons-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/buttons-light.png">
  <img src="docs/images/buttons-light.png" alt="Button variants" />
</picture>

```blade
<x-ui::button variant="outline">Outline</x-ui::button>
<x-ui::button variant="primary">Primary</x-ui::button>
<x-ui::button variant="secondary">Secondary</x-ui::button>
<x-ui::button variant="danger">Danger</x-ui::button>
<x-ui::button variant="ghost">Ghost</x-ui::button>
<x-ui::button variant="subtle">Subtle</x-ui::button>
<x-ui::button variant="link">Link</x-ui::button>

<x-ui::button variant="primary" size="xs">Extra small</x-ui::button>
<x-ui::button variant="primary" size="sm">Small</x-ui::button>
<x-ui::button variant="primary">Default</x-ui::button>
<x-ui::button variant="primary" size="lg">Large</x-ui::button>
<x-ui::button variant="outline" square>
    <x-ui::icon.loading />
</x-ui::button>
```

```bash
php artisan stencil:add button icon
```

The square button uses the built-in loading icon from `stencil:add icon`.

<br>

## Input

Affixes, `prefix` / `suffix` (shortcut sugar for `input.group` + `group.prefix` / `group.suffix`), and `invalid`, `disabled`, and `readonly` states.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/input-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/input-light.png">
  <img src="docs/images/input-light.png" alt="Input" />
</picture>

```blade
<x-ui::input name="email" type="email" placeholder="you@example.com">
    <x-slot:leading>
        <x-ui::icon.loading />
    </x-slot:leading>
    <x-slot:trailing>
        <x-ui::text inline size="sm" variant="subtle">Clear</x-ui::text>
    </x-slot:trailing>
</x-ui::input>

<x-ui::input name="site" placeholder="yoursite" prefix="https://" suffix=".com" />

{{-- Explicit group composition (same markup as prefix / suffix shortcuts) --}}
<x-ui::input.group class="max-w-md">
    <x-ui::input.group.prefix>https://</x-ui::input.group.prefix>
    <x-ui::input name="website" in-group placeholder="example.com" />
    <x-ui::input.group.suffix>.com</x-ui::input.group.suffix>
</x-ui::input.group>

<x-ui::input name="email" value="not-an-email" invalid />

<x-ui::input name="a" placeholder="Disabled" disabled />
<x-ui::input name="b" value="Read only" readonly />

<x-ui::button variant="outline">Button</x-ui::button>
<x-ui::input name="align-default" placeholder="Input" class="w-36" />
<x-ui::select name="align-select-default" placeholder="Select…" class="w-40">
    <x-ui::select.item value="a">Option A</x-ui::select.item>
</x-ui::select>
<x-ui::switch name="align-switch-default" :checked="true" />

<x-ui::button variant="outline" size="sm">Button</x-ui::button>
<x-ui::input name="align-sm" size="sm" placeholder="Input" class="w-36" />
<x-ui::select name="align-select-sm" size="sm" placeholder="Select…" class="w-40">
    <x-ui::select.item value="a">Option A</x-ui::select.item>
</x-ui::select>
<x-ui::switch name="align-switch-sm" size="sm" :checked="true" />
```

```bash
php artisan stencil:add input icon select switch
```

<br>

## Input Currency

Formatted currency display aligned with Laravel [`Number::currency`](https://laravel.com/docs/helpers#method-number-currency). The visible field shows locale-aware formatting; a hidden input submits a decimal string your backend can cast to `float` (for example `(float) $request->input('amount')`). Default `mode` is `cents` (digit mask). Requires the `intl` PHP extension. `stencil:add input-currency` copies `input-currency.js` and patches your Vite entry.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/input-currency-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/input-currency-light.png">
  <img src="docs/images/input-currency-light.png" alt="Input Currency" />
</picture>

```blade
<x-ui::field name="amount">
    <x-ui::field.label>Amount</x-ui::field.label>
    <x-ui::input.currency
        name="amount"
        :value="old('amount', $product->price)"
        currency="BRL"
        locale="pt_BR"
        :precision="2"
        placeholder="0,00"
    />
    <x-ui::field.errors name="amount" />
</x-ui::field>
```

```bash
php artisan stencil:add input-currency
```

<br>

## Label

Accessible `<label>` with optional `badge` and `required` marker. Pairs with any control via `for` (see [shadcn Label](https://ui.shadcn.com/docs/components/aria/label) and [Flux label](https://fluxui.dev/components/field)).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/label-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/label-light.png">
  <img src="docs/images/label-light.png" alt="Label" />
</picture>

```blade
<x-ui::label for="email">Email</x-ui::label>
<x-ui::input name="email" id="email" type="email" placeholder="you@example.com" />

<x-ui::label for="phone" badge="Optional">Phone</x-ui::label>
<x-ui::input name="phone" id="phone" placeholder="(555) 555-5555" />

<x-ui::label for="password" badge="Required" :required="true">Password</x-ui::label>
<x-ui::input name="password" id="password" type="password" />
```

```bash
php artisan stencil:add label
```

<br>

## Field

Composable field shell: label, control, description, and Laravel errors — inspired by [shadcn Field](https://ui.shadcn.com/docs/components/radix/field) and [Flux field](https://fluxui.dev/components/field). Use `orientation="inline"` for checkbox/switch rows.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/field-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/field-light.png">
  <img src="docs/images/field-light.png" alt="Field" />
</picture>

```blade
<x-ui::field name="email">
    <x-ui::field.label>Email</x-ui::field.label>
    <x-ui::input name="email" type="email" placeholder="you@example.com" />
    <x-ui::field.description>Used for invoices and receipts.</x-ui::field.description>
</x-ui::field>

<x-ui::field name="username" :invalid="true">
    <x-ui::field.label>Username</x-ui::field.label>
    <x-ui::input name="username" value="taken" />
    <x-ui::field.message variant="error">That username is already taken.</x-ui::field.message>
</x-ui::field>
```

```bash
php artisan stencil:add field
```

<br>

## Textarea

Multi-line control with the same invalid/disabled behavior as `input` ([shadcn Textarea](https://ui.shadcn.com/docs/components/base/textarea)).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/textarea-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/textarea-light.png">
  <img src="docs/images/textarea-light.png" alt="Textarea" />
</picture>

```blade
<x-ui::textarea name="bio" placeholder="About you…" rows="3" />
<x-ui::textarea name="bio-sm" size="sm" placeholder="About you…" rows="3" />
<x-ui::textarea name="bio-invalid" :invalid="true" value="Too short" />
<x-ui::textarea name="bio-disabled" disabled placeholder="Disabled" />
```

```bash
php artisan stencil:add textarea
```

<br>

## Checkbox

Native checkbox for forms and multi-select ([Flux checkbox](https://fluxui.dev/docs)).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/checkbox-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/checkbox-light.png">
  <img src="docs/images/checkbox-light.png" alt="Checkbox" />
</picture>

```blade
<x-ui::field name="a" orientation="inline">
    <x-ui::checkbox name="a" :checked="true" />
    <x-ui::field.label>Default size</x-ui::field.label>
</x-ui::field>
<x-ui::field name="b" orientation="inline">
    <x-ui::checkbox name="b" size="sm" :checked="true" />
    <x-ui::field.label>Small</x-ui::field.label>
</x-ui::field>
<x-ui::field orientation="inline">
    <x-ui::checkbox name="c" :invalid="true" />
    <x-ui::field.label>Invalid</x-ui::field.label>
</x-ui::field>
<x-ui::field orientation="inline">
    <x-ui::checkbox name="d" disabled />
    <x-ui::field.label>Disabled</x-ui::field.label>
</x-ui::field>
```

```bash
php artisan stencil:add checkbox
```

<br>

## Radio

`radio.group` + `radio` items for single-choice fields ([shadcn Radio Group](https://ui.shadcn.com/docs)).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/radio-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/radio-light.png">
  <img src="docs/images/radio-light.png" alt="Radio" />
</picture>

```blade
<x-ui::radio.group name="plan" legend="Plan">
    <x-ui::radio value="free">Free</x-ui::radio>
    <x-ui::radio value="pro" :checked="true">Pro</x-ui::radio>
    <x-ui::radio value="team">Team</x-ui::radio>
</x-ui::radio.group>
```

```bash
php artisan stencil:add radio
```

<br>

## Switch

`role="switch"` toggle for settings-style UI ([Flux switch](https://fluxui.dev/components/switch)). Prefer `checkbox` inside classic form posts.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/switch-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/switch-light.png">
  <img src="docs/images/switch-light.png" alt="Switch" />
</picture>

```blade
<x-ui::field name="n1" orientation="inline">
    <div class="flex min-w-0 flex-1 flex-col gap-1">
        <x-ui::field.label>Notifications</x-ui::field.label>
    </div>
    <x-ui::switch name="n1" :checked="true" />
</x-ui::field>

<x-ui::field name="n2" orientation="inline">
    <div class="flex min-w-0 flex-1 flex-col gap-1">
        <x-ui::field.label>Notifications</x-ui::field.label>
    </div>
    <x-ui::switch name="n2" size="sm" :checked="true" />
</x-ui::field>

<x-ui::switch name="n3" />
```

```bash
php artisan stencil:add switch
```

<br>

## Select

Accessible listbox (not a native `<select>`). Subcomponents include `trigger`, `value`, `chips`, `chip`, `content`, `group`, `label`, `item`, and `separator`. `stencil:add select` copies `select.js` and patches your Vite entry (for example `resources/js/app.js`) to import it.

Use `multiple` for multi-select. The field name is normalized to `name[]` when needed. Pass `:value` as an array for pre-selected options. `display="count"` (default) shows a summary such as `3 selected`; `display="chips"` shows removable badges in the trigger (compose with `select.chips` inside `select.trigger` when `shortcut` is false).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/select-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/select-light.png">
  <img src="docs/images/select-light.png" alt="Select" />
</picture>

```blade
<x-ui::select name="industry" placeholder="Choose industry…">
    <x-ui::select.group>
        <x-ui::select.label>Creative</x-ui::select.label>
        <x-ui::select.item value="photo">Photography</x-ui::select.item>
        <x-ui::select.item value="design">Design services</x-ui::select.item>
    </x-ui::select.group>
    <x-ui::select.separator />
    <x-ui::select.item value="web">Web development</x-ui::select.item>
    <x-ui::select.item value="other">Other</x-ui::select.item>
</x-ui::select>

<x-ui::select name="role" size="sm" placeholder="Select a role…">
    <x-ui::select.item value="admin">Admin</x-ui::select.item>
    <x-ui::select.item value="editor">Editor</x-ui::select.item>
</x-ui::select>
<x-ui::select name="bad" placeholder="Invalid" invalid>
    <x-ui::select.item value="x">Option</x-ui::select.item>
</x-ui::select>
<x-ui::select name="off" placeholder="Disabled" disabled>
    <x-ui::select.item value="x">Option</x-ui::select.item>
</x-ui::select>

<x-ui::select name="industries" :multiple="true" placeholder="Choose industries…">
    <x-ui::select.item value="photo">Photography</x-ui::select.item>
    <x-ui::select.item value="web">Web development</x-ui::select.item>
</x-ui::select>

<x-ui::select name="tags" :multiple="true" display="chips" placeholder="Add tags…">
    <x-ui::select.item value="laravel">Laravel</x-ui::select.item>
    <x-ui::select.item value="tailwind">Tailwind</x-ui::select.item>
</x-ui::select>
```

```bash
php artisan stencil:add select
```

<br>

## Combobox

Accessible filterable combobox / autocomplete (WAI-ARIA combobox + listbox). Subcomponents include `input`, `content`, `empty`, `group`, `label`, `item`, and `separator`. `stencil:add combobox` copies `combobox.js` and patches your Vite entry. Single-select for now; typeahead filters options client-side and shows the empty state when nothing matches.

Default `shortcut` wraps items with `combobox.input`, `combobox.content`, and `combobox.empty`. Set `:shortcut="false"` for full composition. Works inside `field` (inherits `invalid` / Laravel `$errors`).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/combobox-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/combobox-light.png">
  <img src="docs/images/combobox-light.png" alt="Combobox" />
</picture>

```blade
<x-ui::combobox name="framework" placeholder="Search frameworks…">
    <x-ui::combobox.group>
        <x-ui::combobox.label>PHP</x-ui::combobox.label>
        <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
        <x-ui::combobox.item value="symfony">Symfony</x-ui::combobox.item>
    </x-ui::combobox.group>
    <x-ui::combobox.separator />
    <x-ui::combobox.item value="react">React</x-ui::combobox.item>
    <x-ui::combobox.item value="vue">Vue</x-ui::combobox.item>
</x-ui::combobox>

<x-ui::combobox name="lang" size="sm" placeholder="Find a language…">
    <x-ui::combobox.item value="php">PHP</x-ui::combobox.item>
    <x-ui::combobox.item value="js">JavaScript</x-ui::combobox.item>
</x-ui::combobox>

<x-ui::combobox name="bad" placeholder="Invalid" invalid>
    <x-ui::combobox.item value="x">Option</x-ui::combobox.item>
</x-ui::combobox>

<x-ui::combobox name="off" placeholder="Disabled" disabled>
    <x-ui::combobox.item value="x">Option</x-ui::combobox.item>
</x-ui::combobox>

{{-- Full composition --}}
<x-ui::combobox name="framework" :shortcut="false">
    <x-ui::combobox.input placeholder="Search frameworks…" />
    <x-ui::combobox.content>
        <x-ui::combobox.empty>No frameworks found.</x-ui::combobox.empty>
        <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
    </x-ui::combobox.content>
</x-ui::combobox>

<x-ui::field name="framework">
    <x-ui::field.label>Framework</x-ui::field.label>
    <x-ui::combobox name="framework" placeholder="Search…">
        <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
    </x-ui::combobox>
    <x-ui::field.errors name="framework" />
</x-ui::field>
```

```bash
php artisan stencil:add combobox
```

<br>

## File Upload

Accessible file upload with a drag-and-drop dropzone, selected-file list, and client-side remove. Uses a native `<input type="file">` so multipart form submit works without Livewire. Subcomponents include `dropzone`, `list`, `item`, and `item.remove`. `stencil:add file-upload` copies `file-upload.js` and patches your Vite entry.

Default `shortcut` renders a dropzone (customize via the slot or `heading` / `text` props), a file list, and an item template for the script. Set `:shortcut="false"` for full composition. Use `multiple` for multi-file fields (name is normalized to `name[]` when needed). Works inside `field` (inherits `invalid` / Laravel `$errors`).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/file-upload-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/file-upload-light.png">
  <img src="docs/images/file-upload-light.png" alt="File Upload" />
</picture>

```blade
<x-ui::file-upload name="avatar" accept="image/*" text="PNG or JPG up to 5MB" />

<x-ui::file-upload name="attachments" :multiple="true" accept=".pdf,.doc,.docx">
    <x-ui::file-upload.dropzone heading="Upload documents" text="PDF or Word up to 10MB" />
</x-ui::file-upload>

<x-ui::file-upload name="bad" invalid text="Invalid upload" />
<x-ui::file-upload name="off" disabled text="Disabled upload" />

{{-- Full composition --}}
<x-ui::file-upload name="docs" :multiple="true" :shortcut="false">
    <x-ui::file-upload.dropzone heading="Drop files here" text="Any type" />
    <x-ui::file-upload.list />
</x-ui::file-upload>

<x-ui::field name="avatar">
    <x-ui::field.label>Avatar</x-ui::field.label>
    <x-ui::file-upload name="avatar" accept="image/*" />
    <x-ui::field.errors name="avatar" />
</x-ui::field>
```

Wrap the control in a form with `enctype="multipart/form-data"` (Laravel forms that include files do this automatically when using `@csrf` with `files` / `enctype`).

```bash
php artisan stencil:add file-upload
```

<br>

## Repeater

Composition-first repeater for dynamic Laravel array fields. Subcomponents include `item`, `add`, and `remove`. `stencil:add repeater` copies `repeater.js` and patches your Vite entry.

Declare one `repeater.item` row template with `data-repeater-field` on each control. The script clones rows, reindexes `name="members[0][field]"` attributes, and hydrates from `:value` / `old()`. Use `min` / `max` to control row limits. Works inside `field` (inherits `invalid` / Laravel `$errors`).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/repeater-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/repeater-light.png">
  <img src="docs/images/repeater-light.png" alt="Repeater" />
</picture>

```blade
<x-ui::repeater name="members" :value="old('members', [])" :min="1" :max="10">
    <x-ui::repeater.item>
        <x-ui::input data-repeater-field="name" placeholder="Name" />
        <x-ui::input data-repeater-field="role" placeholder="Role" />
        <x-ui::repeater.remove />
    </x-ui::repeater.item>

    <x-ui::repeater.add>Add member</x-ui::repeater.add>
</x-ui::repeater>

<x-ui::field name="members">
    <x-ui::field.label>Team members</x-ui::field.label>
    <x-ui::repeater name="members" :min="1">
        <x-ui::repeater.item>
            <x-ui::input data-repeater-field="name" placeholder="Name" />
            <x-ui::repeater.remove />
        </x-ui::repeater.item>
        <x-ui::repeater.add />
    </x-ui::repeater>
    <x-ui::field.errors name="members" />
</x-ui::field>
```

v1 limits: no nested repeaters or `file-upload` rows inside a repeater item. Use `repeater.duplicate` to clone a row, `repeater.handle` with `sortable` for drag reorder, and `field.errors` with wildcard names like `members.*.name` for per-index validation messages.

Validate the collection and each row field on the server:

```php
$request->validate([
    'members' => ['required', 'array', 'min:1', 'max:10'],
    'members.*.name' => ['required', 'string', 'max:255'],
    'members.*.role' => ['required', 'string', 'max:255'],
]);
```

Put `data-repeater-field` on the control that should submit (usually the `input` itself). After add/remove, the script dispatches `stencil:mount` so sibling Stencil widgets (`select`, `combobox`, date/time pickers, etc.) can initialize inside cloned rows.

```bash
php artisan stencil:add repeater
```

<br>

## Pillbox

Free-text tags input. Submits multiple strings as `name[]`. Enter or comma adds a tag; Backspace on empty input or chip remove button deletes. `stencil:add pillbox` copies `pillbox.js`.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/pillbox-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/pillbox-light.png">
  <img src="docs/images/pillbox-light.png" alt="Pillbox" />
</picture>

```blade
<x-ui::pillbox name="tags" :value="old('tags', [])" placeholder="Add tags…" :max="10" />

<x-ui::field name="tags">
    <x-ui::field.label>Tags</x-ui::field.label>
    <x-ui::pillbox name="tags" />
    <x-ui::field.errors name="tags" />
</x-ui::field>
```

```bash
php artisan stencil:add pillbox
```

<br>

## Input enhancements

The `input` primitive supports optional QoL props (requires `input-enhancements.js` from `stencil:add input`):

- `mask` — pattern string; `#` = digit, `A` = letter, anything else is literal
- `viewable` on `type="password"` — toggle visibility
- `copyable` — copy value to clipboard
- `counter` with `maxlength` — live character count

```blade
<x-ui::input name="phone" mask="(##) #####-####" />
<x-ui::input name="cpf" mask="###.###.###-##" />
<x-ui::input name="plate" mask="AAA-#A##" />
<x-ui::input name="password" type="password" viewable />
<x-ui::input name="token" copyable />
<x-ui::input name="title" counter maxlength="80" />
```

<br>

## Textarea enhancements

`autosize` grows height with content; `counter` with `maxlength` shows a live count (`textarea.js`).

```blade
<x-ui::textarea name="bio" autosize counter maxlength="500" />
```

<br>

## Combobox multiple

Pass `multiple` with `display="count"` or `display="chips"`. Hidden inputs use `name[]`.

```blade
<x-ui::combobox name="frameworks" multiple display="chips" :value="['laravel']">
    <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
    <x-ui::combobox.item value="vue">Vue</x-ui::combobox.item>
</x-ui::combobox>
```

<br>

## Rating

Star rating with numeric hidden value. `stencil:add rating` copies `rating.js`.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/rating-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/rating-light.png">
  <img src="docs/images/rating-light.png" alt="Rating" />
</picture>

```blade
<x-ui::rating name="score" :value="3" :max="5" />
```

<br>

## Color Picker

SV canvas, hue slider, Tailwind swatches, and hex field in a popover. Subcomponents include `trigger`, `hex`, `content`, `area`, `hue`, `dropper`, `swatches`, and `swatch`. `stencil:add color-picker` copies `color-picker.js`.

Default `shortcut` composes the trigger and popover tree. Use `:dropper="true"` or `:swatches="false"` on the root, or nest parts explicitly with `:shortcut="false"`.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/color-picker-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/color-picker-light.png">
  <img src="docs/images/color-picker-light.png" alt="Color Picker" />
</picture>

```blade
<x-ui::color-picker name="brand_color" value="#3366cc" />
<x-ui::color-picker name="accent" :dropper="true" />
<x-ui::color-picker name="theme" :swatches="['#ef4444', '#22c55e', '#3b82f6']" />

<x-ui::color-picker name="brand_color" value="#3366cc" :shortcut="false">
    <x-ui::color-picker.trigger current-value="#3366cc" popover-id="brand-popover">
        <x-ui::color-picker.hex current-value="#3366cc" popover-id="brand-popover" />
    </x-ui::color-picker.trigger>
    <x-ui::color-picker.content popover-id="brand-popover">
        <x-ui::color-picker.area />
        <x-ui::color-picker.hue />
        <x-ui::color-picker.dropper />
        <x-ui::color-picker.swatches />
    </x-ui::color-picker.content>
</x-ui::color-picker>
```

<br>

## Date Picker

Calendar popover with optional range mode, presets sidebar, manual inputs, and confirmation footer. Subcomponents include `button`, `selected`, `input`, `panel`, `presets`, `manual-inputs`, and `footer`. `stencil:add date-picker` copies `date-picker.js` and `calendar.js`.

`withPresets`, `withInputs`, and `withConfirmation` are shortcut conveniences that compose the matching panel parts.

```blade
<x-ui::date-picker name="published_at" value="2026-07-29" />

<x-ui::date-picker name="range_at" mode="range" with-presets with-inputs with-confirmation />

<x-ui::date-picker name="published_at" value="2026-07-29" :shortcut="false">
    <x-ui::date-picker.button />
    <x-ui::date-picker.panel>
        <x-ui::date-picker.manual-inputs />
        <x-ui::calendar value="2026-07-29" />
        <x-ui::date-picker.footer />
    </x-ui::date-picker.panel>
</x-ui::date-picker>
```

<br>

## Datetime Picker

Date + time selection with calendar and scrollable time list. Subcomponents include `panel`, `time-list`, and `footer`. Reuses `date-picker.button` for the trigger. `stencil:add datetime-picker` copies `datetime-picker.js`.

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

## Input OTP

Accessible one-time password / PIN input with labeled slots, paste support, and arrow/backspace navigation. Subcomponents include `group`, `slot`, and `separator`. `stencil:add input-otp` copies `input-otp.js` and patches your Vite entry. A hidden input carries the combined value for form submit (`name`).

Default `shortcut` renders slots for `length` (default `6`). Even lengths ≥ 4 include a middle separator unless you set `:separated="false"`. Use `mode="numeric"` (default) or `mode="alphanumeric"`. Set `:shortcut="false"` for full composition. Works inside `field` (inherits `invalid` / Laravel `$errors`).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/input-otp-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/input-otp-light.png">
  <img src="docs/images/input-otp-light.png" alt="Input OTP" />
</picture>

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

```bash
php artisan stencil:add input-otp
```

<br>

## Slider

Accessible slider and dual-thumb range control (WAI-ARIA `role="slider"`). Subcomponents include `track`, `range`, and `thumb`. `stencil:add slider` copies `slider.js` and patches your Vite entry. A hidden input carries the value for form submit (`name`); range mode emits `name[0]` / `name[1]`.

Supports `min` (default `0`), `max` (default `100`), `step` (default `1`), `value` (number or `[low, high]`), and `:range="true"` for two thumbs. Keyboard: arrows, Home/End, PageUp/Down. Set `:shortcut="false"` for full composition. Works inside `field` (inherits `invalid` / Laravel `$errors`).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/slider-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/slider-light.png">
  <img src="docs/images/slider-light.png" alt="Slider" />
</picture>

```blade
<x-ui::slider name="volume" :value="40" />

<x-ui::slider name="level" :min="0" :max="50" :step="5" :value="25" />

<x-ui::slider name="price" :value="[20, 80]" />

<x-ui::slider name="span" :range="true" />

<x-ui::slider name="bad" invalid />
<x-ui::slider name="off" disabled />

{{-- Full composition --}}
<x-ui::slider name="volume" :value="40" :shortcut="false">
    <x-ui::slider.track>
        <x-ui::slider.range />
    </x-ui::slider.track>
    <x-ui::slider.thumb :index="0" :value="40" />
</x-ui::slider>

<x-ui::field name="volume">
    <x-ui::field.label>Volume</x-ui::field.label>
    <x-ui::slider name="volume" :value="40" />
    <x-ui::field.errors name="volume" />
</x-ui::field>
```

```bash
php artisan stencil:add slider
```

<br>

## Dialog

Accessible modal layer on the native `<dialog>` element ([shadcn alert dialog](https://ui.shadcn.com/docs/components/base/alert-dialog) composition, [Flux modal](https://fluxui.dev/components/modal) ergonomics). Subcomponents include `trigger`, `content`, `header`, `title`, `description`, `footer`, `close`, `cancel`, and `action`. `stencil:add dialog` copies `dialog.js` and patches your Vite entry alongside any other Stencil scripts (for example `select.js`).

Named triggers can live anywhere on the page; use the same `name` on `dialog.trigger` and `dialog.content`. Control dialogs from JavaScript with `window.Stencil.dialog('name').show()` and `window.Stencil.dialogs.closeAll()`.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/dialog-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/dialog-light.png">
  <img src="docs/images/dialog-light.png" alt="Dialog and alert dialog" />
</picture>

```blade
<x-ui::dialog>
    <x-ui::dialog.trigger>
        <x-ui::button variant="outline">Edit profile</x-ui::button>
    </x-ui::dialog.trigger>

    <x-ui::dialog.content>
        <x-ui::dialog.header>
            <x-ui::dialog.title>Update profile</x-ui::dialog.title>
            <x-ui::dialog.description>Make changes to your personal details.</x-ui::dialog.description>
        </x-ui::dialog.header>

        <x-ui::input name="name" placeholder="Your name" class="mt-4" />

        <x-ui::dialog.footer>
            <x-ui::dialog.cancel>Cancel</x-ui::dialog.cancel>
            <x-ui::dialog.action>Save changes</x-ui::dialog.action>
        </x-ui::dialog.footer>
    </x-ui::dialog.content>
</x-ui::dialog>

<x-ui::dialog.trigger name="delete-project">
    <x-ui::button variant="danger">Delete</x-ui::button>
</x-ui::dialog.trigger>

<x-ui::dialog.content name="delete-project" size="sm" :alert="true">
    <x-ui::dialog.header>
        <x-ui::dialog.title>Delete project?</x-ui::dialog.title>
        <x-ui::dialog.description>
            You're about to delete this project. This action cannot be reversed.
        </x-ui::dialog.description>
    </x-ui::dialog.header>
    <x-ui::dialog.footer>
        <x-ui::dialog.cancel>Cancel</x-ui::dialog.cancel>
        <x-ui::dialog.action variant="danger">Delete project</x-ui::dialog.action>
    </x-ui::dialog.footer>
</x-ui::dialog.content>
```

| Prop (on `content`) | Description |
| --- | --- |
| `size` | `default` or `sm` |
| `flyout` | Sheet-style panel (`flyoutPosition`: `right`, `left`, `bottom`) |
| `alert` | Sets `role="alertdialog"` for confirmations |
| `dismissible` | Click outside / Escape closes when `true` (default) |
| `closable` | Shows the corner close control (default) |
| `preview` | Static, in-page preview for docs (no JS) |

```bash
php artisan stencil:add dialog
```

<br>

## Accordion

Accessible vertically stacked disclosures ([shadcn Accordion](https://ui.shadcn.com/docs/components/accordion), [Flux accordion](https://fluxui.dev/components/accordion)). Subcomponents include `item`, `trigger`, and `content`. `stencil:add accordion` copies `accordion.js` and patches your Vite entry.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/accordion-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/accordion-light.png">
  <img src="docs/images/accordion-light.png" alt="Accordion" />
</picture>

```blade
<x-ui::accordion exclusive transition>
    <x-ui::accordion.item value="shipping" :expanded="true">
        <x-ui::accordion.trigger>What are your shipping options?</x-ui::accordion.trigger>
        <x-ui::accordion.content>
            Standard (5–7 days), express (2–3 days), and overnight.
        </x-ui::accordion.content>
    </x-ui::accordion.item>

    <x-ui::accordion.item heading="What is your return policy?">
        30-day money-back guarantee on unused items.
    </x-ui::accordion.item>
</x-ui::accordion>
```

| Prop | Description |
| --- | --- |
| `exclusive` / `multiple` | Single open item (`exclusive`) or many (`multiple`) |
| `transition` | Animate open/close height |
| `variant="reverse"` | Chevron before the label (Flux) |
| `bordered` | Rounded bordered shell |
| `item` → `heading` | Shorthand trigger text (Flux) |
| `item` → `expanded` / `disabled` | Default open / non-interactive |

```bash
php artisan stencil:add accordion
```

<br>

## Collapsible

Single-panel expand/collapse ([shadcn Collapsible](https://ui.shadcn.com/docs/components/collapsible)). Subcomponents include `trigger` and `content`. `stencil:add collapsible` copies `collapsible.js`.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/collapsible-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/collapsible-light.png">
  <img src="docs/images/collapsible-light.png" alt="Collapsible" />
</picture>

```blade
<x-ui::collapsible>
    <x-ui::collapsible.trigger>Toggle details</x-ui::collapsible.trigger>
    <x-ui::collapsible.content>
        Extra product information lives here.
    </x-ui::collapsible.content>
</x-ui::collapsible>
```

```bash
php artisan stencil:add collapsible
```

<br>

## Avatar

User image or initials ([shadcn Avatar](https://ui.shadcn.com/docs/components/avatar), [Flux avatar](https://fluxui.dev/components/avatar)). Subcomponents include `image`, `fallback`, and `group`. `stencil:add avatar` copies `avatar.js` for image-error fallback.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/avatar-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/avatar-light.png">
  <img src="docs/images/avatar-light.png" alt="Avatar" />
</picture>

```blade
<x-ui::avatar src="https://example.com/me.jpg" name="Caleb Porzio" circle size="lg" />
<x-ui::avatar name="Ada Lovelace" color="violet" />

<x-ui::avatar.group>
    <x-ui::avatar name="One" circle />
    <x-ui::avatar name="Two" circle />
</x-ui::avatar.group>
```

```bash
php artisan stencil:add avatar
```

<br>

## Badge

Compact status label ([shadcn Badge](https://ui.shadcn.com/docs/components/badge), [Flux badge](https://fluxui.dev/components/badge)). Optional `badge.close` for dismissible chips.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/badge-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/badge-light.png">
  <img src="docs/images/badge-light.png" alt="Badge" />
</picture>

```blade
<x-ui::badge variant="destructive">Failed</x-ui::badge>
<x-ui::badge color="lime" rounded>New</x-ui::badge>
<x-ui::badge>Admin <x-ui::badge.close /></x-ui::badge>
```

```bash
php artisan stencil:add badge
```

<br>

## Breadcrumb

Navigation trail ([shadcn Breadcrumb](https://ui.shadcn.com/docs/components/breadcrumb), [Flux breadcrumbs](https://fluxui.dev/components/breadcrumbs)).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/breadcrumb-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/breadcrumb-light.png">
  <img src="docs/images/breadcrumb-light.png" alt="Breadcrumb" />
</picture>

```blade
<x-ui::breadcrumb>
    <x-ui::breadcrumb.list>
        <x-ui::breadcrumb.item href="/">Home</x-ui::breadcrumb.item>
        <x-ui::breadcrumb.separator />
        <x-ui::breadcrumb.item>
            <x-ui::breadcrumb.page>Settings</x-ui::breadcrumb.page>
        </x-ui::breadcrumb.item>
    </x-ui::breadcrumb.list>
</x-ui::breadcrumb>
```

```bash
php artisan stencil:add breadcrumb
```

<br>

## Card

Content container ([shadcn Card](https://ui.shadcn.com/docs/components/card), [Flux card](https://fluxui.dev/components/card)).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/card-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/card-light.png">
  <img src="docs/images/card-light.png" alt="Card" />
</picture>

```blade
<x-ui::card>
    <x-ui::card.header>
        <x-ui::card.title>Account</x-ui::card.title>
        <x-ui::card.description>Manage your profile.</x-ui::card.description>
    </x-ui::card.header>
    <x-ui::card.content>…</x-ui::card.content>
    <x-ui::card.footer>
        <x-ui::button>Save</x-ui::button>
    </x-ui::card.footer>
</x-ui::card>
```

```bash
php artisan stencil:add card
```

<br>

## Dropdown Menu

Accessible action menu ([shadcn Dropdown Menu](https://ui.shadcn.com/docs/components/dropdown-menu), [Flux dropdown](https://fluxui.dev/components/dropdown)). `stencil:add dropdown-menu` copies `dropdown-menu.js`.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/dropdown-menu-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/dropdown-menu-light.png">
  <img src="docs/images/dropdown-menu-light.png" alt="Dropdown Menu" />
</picture>

```blade
<x-ui::dropdown-menu align="end">
    <x-ui::dropdown-menu.trigger>
        <x-ui::button variant="outline">Open</x-ui::button>
    </x-ui::dropdown-menu.trigger>
    <x-ui::dropdown-menu.content>
        <x-ui::dropdown-menu.label>Account</x-ui::dropdown-menu.label>
        <x-ui::dropdown-menu.item>Profile</x-ui::dropdown-menu.item>
        <x-ui::dropdown-menu.separator />
        <x-ui::dropdown-menu.item variant="danger" kbd="⌘⌫">Delete</x-ui::dropdown-menu.item>
    </x-ui::dropdown-menu.content>
</x-ui::dropdown-menu>
```

```bash
php artisan stencil:add dropdown-menu
```

<br>

## Separator

Horizontal or vertical divider ([shadcn Separator](https://ui.shadcn.com/docs/components/separator)).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/separator-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/separator-light.png">
  <img src="docs/images/separator-light.png" alt="Separator" />
</picture>

```blade
<x-ui::separator />
<x-ui::separator orientation="vertical" :decorative="false" />
```

```bash
php artisan stencil:add separator
```

<br>

## Skeleton

Loading placeholder ([shadcn Skeleton](https://ui.shadcn.com/docs/components/skeleton)).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/skeleton-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/skeleton-light.png">
  <img src="docs/images/skeleton-light.png" alt="Skeleton" />
</picture>

```blade
<x-ui::skeleton class="h-4 w-48" />
<x-ui::skeleton rounded="full" class="size-10" />
```

```bash
php artisan stencil:add skeleton
```

<br>

## Tabs

Tabbed panels ([shadcn Tabs](https://ui.shadcn.com/docs/components/tabs), [Flux tabs](https://fluxui.dev/components/tabs)). Variants: `default`, `segmented`, `pills`, `line`. `stencil:add tabs` copies `tabs.js`.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/tabs-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/tabs-light.png">
  <img src="docs/images/tabs-light.png" alt="Tabs" />
</picture>

```blade
<x-ui::tabs default-value="account">
    <x-ui::tabs.list>
        <x-ui::tabs.trigger value="account">Account</x-ui::tabs.trigger>
        <x-ui::tabs.trigger value="password">Password</x-ui::tabs.trigger>
    </x-ui::tabs.list>
    <x-ui::tabs.content value="account">Account settings</x-ui::tabs.content>
    <x-ui::tabs.content value="password">Password settings</x-ui::tabs.content>
</x-ui::tabs>
```

```bash
php artisan stencil:add tabs
```

<br>

## Tooltip

Hover/focus hint ([shadcn Tooltip](https://ui.shadcn.com/docs/components/tooltip)). `stencil:add tooltip` copies `tooltip.js`.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/tooltip-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/tooltip-light.png">
  <img src="docs/images/tooltip-light.png" alt="Tooltip" />
</picture>

```blade
<x-ui::tooltip side="top">
    <x-ui::tooltip.trigger>
        <x-ui::button variant="outline">Hover</x-ui::button>
    </x-ui::tooltip.trigger>
    <x-ui::tooltip.content>Add to library</x-ui::tooltip.content>
</x-ui::tooltip>
```

```bash
php artisan stencil:add tooltip
```

<br>

## Toast

Transient notifications / Sonner-style toasts ([shadcn Toast](https://ui.shadcn.com/docs/components/toast)). Mount `toast.provider` once, then render toasts or call `window.Stencil.toast({ title, description, variant })`.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/toast-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/toast-light.png">
  <img src="docs/images/toast-light.png" alt="Toast" />
</picture>

```blade
<x-ui::toast.provider>
    <x-ui::toast variant="success" title="Saved" description="Your changes were saved." />
</x-ui::toast.provider>
```

```bash
php artisan stencil:add toast
```

<br>

## Progress

Progress bar ([shadcn Progress](https://ui.shadcn.com/docs/components/progress)).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/progress-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/progress-light.png">
  <img src="docs/images/progress-light.png" alt="Progress" />
</picture>

```blade
<x-ui::progress :value="40" />
<x-ui::progress indeterminate />
```

```bash
php artisan stencil:add progress
```

<br>

## Alert

Inline callout ([shadcn Alert](https://ui.shadcn.com/docs/components/alert)). Variants: `default`, `info`, `success`, `warning`, `danger`.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/alert-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/alert-light.png">
  <img src="docs/images/alert-light.png" alt="Alert" />
</picture>

```blade
<x-ui::alert variant="warning" title="Heads up">
    <x-ui::alert.description>Check your billing details.</x-ui::alert.description>
</x-ui::alert>
```

```bash
php artisan stencil:add alert
```

<br>

## Table

Semantic data table ([shadcn Table](https://ui.shadcn.com/docs/components/table), [Flux table](https://fluxui.dev/components/table)).

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/table-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/table-light.png">
  <img src="docs/images/table-light.png" alt="Table" />
</picture>

```blade
<x-ui::table>
    <x-ui::table.caption>Recent invoices</x-ui::table.caption>
    <x-ui::table.header>
        <x-ui::table.row>
            <x-ui::table.head>Invoice</x-ui::table.head>
            <x-ui::table.head>Amount</x-ui::table.head>
        </x-ui::table.row>
    </x-ui::table.header>
    <x-ui::table.body>
        <x-ui::table.row>
            <x-ui::table.cell variant="strong">INV001</x-ui::table.cell>
            <x-ui::table.cell>$250.00</x-ui::table.cell>
        </x-ui::table.row>
    </x-ui::table.body>
</x-ui::table>
```

```bash
php artisan stencil:add table
```

<br>

## Pagination

Page controls ([shadcn Pagination](https://ui.shadcn.com/docs/components/pagination)). Compose manually or pass a Laravel `LengthAwarePaginator`.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/pagination-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/pagination-light.png">
  <img src="docs/images/pagination-light.png" alt="Pagination" />
</picture>

```blade
<x-ui::pagination :paginator="$orders" />

<x-ui::pagination>
    <x-ui::pagination.content>
        <x-ui::pagination.item>
            <x-ui::pagination.previous href="?page=1" />
        </x-ui::pagination.item>
        <x-ui::pagination.item>
            <x-ui::pagination.link href="?page=2" :is-active="true">2</x-ui::pagination.link>
        </x-ui::pagination.item>
        <x-ui::pagination.item>
            <x-ui::pagination.next href="?page=3" />
        </x-ui::pagination.item>
    </x-ui::pagination.content>
</x-ui::pagination>
```

```bash
php artisan stencil:add pagination
```

<br>

## Typography

`<x-ui::heading />` with semantic levels `1`–`6` and `<x-ui::text />` with the `sm` / `default` / `lg` / `xl` scale, variants, and colors.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/typography-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/typography-light.png">
  <img src="docs/images/typography-light.png" alt="Typography" />
</picture>

```blade
<x-ui::heading :level="1">Heading level 1</x-ui::heading>
<x-ui::heading :level="2">Heading level 2</x-ui::heading>
<x-ui::heading :level="3">Heading level 3</x-ui::heading>
<x-ui::heading :level="4" variant="subtle">Subtle heading</x-ui::heading>

<x-ui::text size="xl">Extra large body</x-ui::text>
<x-ui::text size="lg">Large body copy</x-ui::text>
<x-ui::text>Default body copy with a shared scale.</x-ui::text>
<x-ui::text size="sm" variant="subtle">Small subtle meta text</x-ui::text>
<x-ui::text variant="strong">Strong emphasis</x-ui::text>
<x-ui::text variant="error">Error message</x-ui::text>
<x-ui::text inline color="blue">Blue</x-ui::text>
<x-ui::text inline color="emerald"> · Emerald</x-ui::text>
<x-ui::text inline color="red"> · Red</x-ui::text>
```

```bash
php artisan stencil:add text heading
```

<br>

## Icons

On-demand [Lucide](https://lucide.dev/icons/) icons — `outline` (16px), `mini` (20px), and `micro` (12px) variants. The built-in loading spinner ships with `stencil:add icon`.

```bash
php artisan stencil:add icon
php artisan stencil:icon search
```

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/icons-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/icons-light.png">
  <img src="docs/images/icons-light.png" alt="Icons" />
</picture>

```blade
<x-ui::icon.loading class="size-4" />
<x-ui::icon.loading class="size-5" />
<x-ui::icon.loading class="size-3" />

<x-ui::input name="search" placeholder="Search…">
    <x-slot:leading>
        <x-ui::icon.loading />
    </x-slot:leading>
</x-ui::input>

<x-ui::button variant="primary">
    <x-slot:leading>
        <x-ui::icon.loading class="animate-spin" />
    </x-slot:leading>
    Saving…
</x-ui::button>
```

<br>

## Development

<h3 id="development"></h3>

```bash
composer playbook              # /playbook — interactive playground
composer workbench:build
composer serve
```

Package registry rebuild (contributors):

```bash
composer registry:build
```

To refresh README screenshots, run the workbench on port `8001`, then:

```bash
composer build
php vendor/bin/testbench serve --port=8001   # separate terminal
./scripts/capture-readme-images.sh
```

The script crops to `#readme-media` (fixed `56rem` / 896px width, variable height) with a transparent background at 3× device pixel ratio by default (`STENCIL_SCREENSHOT_SCALE`, `STENCIL_README_MEDIA_WIDTH`; installs `playwright-core` under `scripts/` on first run). Targets: `/playbook/media/{buttons|input|label|field|textarea|checkbox|radio|switch|select|dialog|typography|icons|accordion|collapsible|avatar|badge|breadcrumb|card|dropdown-menu|separator|skeleton|tabs|tooltip|toast|progress|alert|table|pagination}` and the same paths with `?dark=1`.

<br>

## Changelog

[CHANGELOG](CHANGELOG.md)

## Contributing

[Contributing guide](.github/CONTRIBUTING.md)

## Security

[Security policy](.github/SECURITY.md)

## Credits

- [Ivan Führ](https://github.com/ivanfuhr)
- [All Contributors](../../contributors)

## License

[MIT](LICENSE.md)
