<div align="center">

<a href="#sumario">
  <img src="docs/images/hero.svg" alt="BladeX Components" />
</a>

# BladeX Components

**Composable Blade primitives for Laravel — vendor quick start or shadcn-style owned UI.**

<p>
    <a href="https://packagist.org/packages/ivanfuhr/bladex-components"><img src="https://img.shields.io/packagist/v/ivanfuhr/bladex-components.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://packagist.org/packages/ivanfuhr/bladex-components"><img src="https://img.shields.io/packagist/php-v/ivanfuhr/bladex-components.svg?style=flat-square" alt="PHP from Packagist"></a>
    <a href="https://packagist.org/packages/ivanfuhr/bladex-components"><img src="https://badge.laravel.cloud/badge/ivanfuhr/bladex-components?style=flat" alt="Laravel versions"></a>
    <a href="https://github.com/ivanfuhr/bladex-components/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/ivanfuhr/bladex-components/tests.yml?branch=main&label=Tests&style=flat-square"></a>
    <a href="https://packagist.org/packages/ivanfuhr/bladex-components"><img src="https://img.shields.io/packagist/dt/ivanfuhr/bladex-components.svg?style=flat-square" alt="Total Downloads"></a>
</p>

</div>

<br>

<h2 id="sumario" align="center">📑 Sumário</h2>

<table width="100%">
<thead>
<tr>
<th width="34%" align="left">🧩 Componentes</th>
<th width="33%" align="left">📖 Guia</th>
<th width="33%" align="left">🛠 Projeto</th>
</tr>
</thead>
<tbody>
<tr valign="top">
<td>

**Showcase**

- [Button](#button)
- [Input](#input)
- [Select](#select)
- [Typography](#typography)
- [Icons](#icons)

</td>
<td>

**Adoção**

- [Instalação](#installation)
- [Vendor vs owned](#usage)
- [Registry CLI](#registry-cli)
- [Tailwind CSS](#tailwind-css)
- [Playbook local](#development)

</td>
<td>

**Comunidade**

- [Changelog](CHANGELOG.md)
- [Contributing](.github/CONTRIBUTING.md)
- [Security](.github/SECURITY.md)
- [License](LICENSE.md)

</td>
</tr>
</tbody>
</table>

<br>

---

Copie só o que precisa com `bladex-components:add`, use `x-ui::*` no dia a dia e mantenha Tailwind v4 + dark mode alinhados ao design system. As capturas abaixo são **largura total** (clique para abrir em tamanho original).

<br>

## Button

Variantes `outline`, `primary`, `secondary`, `danger`, `ghost`, `subtle`, `link` — tamanhos `xs`–`lg`, modo ícone (`square`) e slots `leading` / `trailing`.

<table width="100%">
<tr>
<td align="center">
<a href="docs/images/buttons-light.png"><img src="docs/images/buttons-light.png" alt="Button variants — light theme" width="100%" /></a>
<br><sub><strong>Light</strong></sub>
</td>
</tr>
<tr>
<td align="center">
<a href="docs/images/buttons-dark.png"><img src="docs/images/buttons-dark.png" alt="Button variants — dark theme" width="100%" /></a>
<br><sub><strong>Dark</strong></sub>
</td>
</tr>
</table>

```blade
<x-ui::button variant="primary" size="lg">Save changes</x-ui::button>

<x-ui::button variant="outline" square>
    <x-ui::icons.search />
</x-ui::button>
```

```bash
php artisan bladex-components:add button
```

<br>

## Input

Affixes, `prefix` / `suffix`, estados `invalid`, `disabled` e `readonly`.

<table width="100%">
<tr>
<td align="center">
<a href="docs/images/input-light.png"><img src="docs/images/input-light.png" alt="Input states — light theme" width="100%" /></a>
<br><sub><strong>Light</strong></sub>
</td>
</tr>
<tr>
<td align="center">
<a href="docs/images/input-dark.png"><img src="docs/images/input-dark.png" alt="Input states — dark theme" width="100%" /></a>
<br><sub><strong>Dark</strong></sub>
</td>
</tr>
</table>

```blade
<x-ui::input name="email" type="email" placeholder="you@example.com">
    <x-slot:leading><x-ui::icons.search /></x-slot:leading>
    <x-slot:trailing>
        <x-ui::text inline size="sm" variant="subtle">Clear</x-ui::text>
    </x-slot:trailing>
</x-ui::input>

<x-ui::input name="site" prefix="https://" suffix=".com" placeholder="yoursite" />
```

```bash
php artisan bladex-components:add input
```

<br>

## Select

Listbox acessível (não é `<select>` nativo). Subcomponentes `trigger`, `value`, `content`, `group`, `item`. Requer `select.js` no Vite após `add select`.

<table width="100%">
<tr>
<td align="center">
<a href="docs/images/select-light.png"><img src="docs/images/select-light.png" alt="Select listbox — light theme" width="100%" /></a>
<br><sub><strong>Light</strong></sub>
</td>
</tr>
<tr>
<td align="center">
<a href="docs/images/select-dark.png"><img src="docs/images/select-dark.png" alt="Select listbox — dark theme" width="100%" /></a>
<br><sub><strong>Dark</strong></sub>
</td>
</tr>
</table>

```blade
<x-ui::select name="industry" placeholder="Choose industry…">
    <x-ui::select.group>
        <x-ui::select.label>Creative</x-ui::select.label>
        <x-ui::select.item value="photo">Photography</x-ui::select.item>
    </x-ui::select.group>
    <x-ui::select.separator />
    <x-ui::select.item value="web">Web development</x-ui::select.item>
</x-ui::select>
```

```bash
php artisan bladex-components:add select
```

<br>

## Typography

`<x-ui::heading />` com níveis semânticos `1`–`6` e `<x-ui::text />` com escala `sm` / `default` / `lg` / `xl`, variantes e cores.

<table width="100%">
<tr>
<td align="center">
<a href="docs/images/typography-light.png"><img src="docs/images/typography-light.png" alt="Heading and text — light theme" width="100%" /></a>
<br><sub><strong>Light</strong></sub>
</td>
</tr>
<tr>
<td align="center">
<a href="docs/images/typography-dark.png"><img src="docs/images/typography-dark.png" alt="Heading and text — dark theme" width="100%" /></a>
<br><sub><strong>Dark</strong></sub>
</td>
</tr>
</table>

```blade
<head>
    <x-bladex-components::fonts />
</head>

<x-ui::heading :level="2">Page title</x-ui::heading>
<x-ui::text variant="subtle" size="sm">Meta line</x-ui::text>
<x-ui::text color="blue">Semantic color</x-ui::text>
```

```bash
php artisan bladex-components:add text heading
```

<br>

## Icons

Ícones [Lucide](https://lucide.dev/icons/) sob demanda — variantes `outline` (16px), `mini` (20px), `micro` (12px).

<table width="100%">
<tr>
<td align="center">
<a href="docs/images/icons-light.png"><img src="docs/images/icons-light.png" alt="Lucide icons — light theme" width="100%" /></a>
<br><sub><strong>Light</strong></sub>
</td>
</tr>
<tr>
<td align="center">
<a href="docs/images/icons-dark.png"><img src="docs/images/icons-dark.png" alt="Lucide icons — dark theme" width="100%" /></a>
<br><sub><strong>Dark</strong></sub>
</td>
</tr>
</table>

```bash
php artisan bladex-components:icon search grip-vertical
```

```blade
<x-ui::icons.search />
<x-ui::icons.search variant="mini" class="text-amber-500" />
```

<br>

---

## Installation

```bash
composer require --dev ivanfuhr/bladex-components
```

O pacote é **dev dependency** (CLI do registry). Depois de `init` + `add`, o app roda com arquivos em `resources/views/ui` e `app/Support/Bladex` — produção pode usar `composer install --no-dev`.

```bash
php artisan vendor:publish --tag="bladex-components"
```

| Tag | Recurso |
| --- | --- |
| `bladex-components-config` | Configuração |
| `bladex-components-views` | Views do pacote |
| `bladex-components-lang` | Traduções |
| `bladex-components-assets` | Assets públicos |

<br>

## Usage

**Vendor (rápido)**

```blade
<x-bladex-components::input name="email" />
```

**Owned (shadcn-style)**

```bash
php artisan bladex-components:init
php artisan bladex-components:add input button select
```

```blade
<x-ui::input name="email" />
```

### Registry CLI

| Command | Description |
| --- | --- |
| `bladex-components:init` | `bladex-components.json`, support/CSS, lock file |
| `bladex-components:add {names}` | Instalar do registry |
| `bladex-components:update {name?}` | Atualizar arquivos instalados |
| `bladex-components:remove {names}` | Remover componentes |
| `bladex-components:list` | Listar registry (`--installed`) |
| `bladex-components:icon {names?}` | Importar ícones Lucide |

### Tailwind CSS

`init` cria `resources/css/bladex.css` e marca o import em `app.css`. Escaneia `resources/views` + `app/Support/Bladex` e registra dark mode por classe (`.dark` no `<html>`).

```css
@import "tailwindcss";

/* bladex-components-start */
@import "./bladex.css";
/* bladex-components-end */
```

Com `APP_DEBUG=true`, falta de integração gera exceção clara (desligue em `bladex-components.validate_tailwind_integration`). Registry padrão: `package://registry.json`. Rebuild: `composer registry:build`.

<br>

## Development

```bash
composer playbook              # /playbook — playground interativo
composer workbench:build
composer serve
```

Atualizar capturas do README (servidor em `http://127.0.0.1:8001`):

```bash
./scripts/capture-readme-images.sh
# Páginas: /playbook/media/{buttons|input|select|typography|icons}?dark=1
```

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
