# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Primary audience: solo developers and small Laravel teams building custom server-rendered UIs with Blade. They need reusable UI pieces without adopting a monolithic design-system product or a framework-specific stack beyond Laravel. They install components into their app, wire Tailwind, and compose interfaces from small, predictable building blocks they own.

## Product Purpose

Stencil is a **development dependency** (`composer require --dev ivanfuhr/stencil`) that provides a **registry CLI** (shadcn-style) for Laravel Blade UI. Consumers run `stencil:init`, browse with `stencil:list`, and install components with `stencil:add`. Installed files are copied into the host app (`resources/views/ui`, CSS/JS patches) and committed; production runs `composer install --no-dev` without the package. Success means accessible, keyboard-complete `x-ui::*` components under the consumer's control, not opaque vendor views.

## Positioning

The product combines two proven models in one Laravel-native package:

- **shadcn-style ownership** — Tailwind-native markup copied into the app and customized (copy, theme, extend) rather than treating components as opaque black boxes.
- **Flux-style ergonomics** — A clear, composable component API (slots, compound children, minimal prop surfaces) instead of sprawling boolean and variant props.

Neighboring kits may offer one side or the other; Stencil is explicitly built to deliver both simplicity of adoption and depth of customization for Blade-first Laravel apps.

## Operating Context

- **Distribution:** Packagist package `ivanfuhr/stencil`, MIT license, GitHub at `ivanfuhr/stencil`. Installed as a **dev dependency**; not required at runtime in production.
- **Registry CLI:** `stencil:init`, `stencil:add`, `stencil:list`, `stencil:update`, `stencil:remove`, `stencil:icon`. Registry source lives in this repo (`registry/`); `composer registry:build` propagates `resources/views/components/` into `registry/items/*.json`.
- **Shipped to consumers:** Owned copies under `resources/views/ui` (plus Tailwind/CSS/JS integration), not the vendor package itself.
- **Runtime (consumer app):** PHP ^8.3, Laravel Illuminate ^12 || ^13; components render as `x-ui::*` Blade views in the host application.
- **Development (this repo):** Orchestra Testbench workbench via `composer build` / `composer serve`; interactive playbook at `/playbook` (`composer playbook`) for visual proof only — **not shipped** to consumers.
- **Validation:** `composer test` (PHPStan, Pint, Pest, type coverage).
- **Documentation & agent guidance:** README, publish tags for config, bundled Laravel Boost skills under `resources/boost/skills/`.
- **Maturity:** Pre-release; registry catalog and CLI are functional; README documents install, CLI, and component usage.

## Capabilities and Constraints

**Confirmed today**

- Registry CLI installs components with transitive `registryDependencies` resolution.
- `stencil:init` scaffolds `stencil.json`, `stencil.lock`, Tailwind integration, support classes, and `StencilUiServiceProvider`.
- Source components in `resources/views/components/` are the canonical implementation; registry JSON is a build artifact.
- Composition-first conventions documented for contributors and agents (primitives, slots, compound dot-named children, `@aware`, attribute merging).
- Tailwind v4 + class-based dark mode (`.dark` on `<html>`) via owned `resources/css/stencil.css`.

**Explicit product commitments**

- Tailwind-native styling aligned with shadcn-like copy-and-customize workflows.
- Component API shaped toward Flux-like composability.
- **Accessible by default** for shipped registry components — not for playbook chrome or workbench-only UI.

**Open / undecided**

- Exact component catalog and release cadence beyond current registry items.
- Formal WCAG level wording vs. the stated bar of full accessibility and full keyboard navigation (see Accessibility & Inclusion).

## Brand Commitments

- **Name:** Stencil (`ivanfuhr/stencil`).
- **Maintainer:** Ivan Führ ([GitHub](https://github.com/ivanfuhr)).
- **Tagline (package metadata):** “Powerful components for Laravel Blade.”
- **Voice:** Technical, Laravel-native, contributor-friendly; SemVer and standard open-source contribution process (see `.github/CONTRIBUTING.md`).

## Evidence on Hand

| Asset | Location / note |
| --- | --- |
| Package README, install & CLI instructions | `README.md` |
| Changelog | `CHANGELOG.md` |
| Composition & development agent skills | `resources/boost/skills/` |
| Contributing & security policies | `.github/CONTRIBUTING.md`, `.github/SECURITY.md` |
| Workbench playbook (dev-only) | `workbench/routes/web.php` → `/playbook` |
| Registry source & build | `resources/views/components/` → `composer registry:build` → `registry/` |

**Do not fabricate:** customer logos, testimonials, download benchmarks, pricing, or production case studies — none are present in the repository.

## Product Principles

1. **Composition over configuration** — Prefer slots and compound sub-components to large prop APIs; one concern per primitive.
2. **Own your markup** — Copied, Tailwind-friendly views so consumers customize like shadcn, not fight opaque packages.
3. **Laravel-first** — Package boundaries, testing, and publishing follow Laravel package norms; no unnecessary abstractions.
4. **Accessible by default** — Shipped components in `resources/views/components/` must be fully accessible and fully keyboard navigable; no optional “a11y mode.” Playbook and workbench chrome are out of scope for this bar.
5. **Prove in the workbench** — Observable behavior, tests, and playbook demos validate components; playbook itself is not production UI.

## Accessibility & Inclusion

Product bar: **100% accessible and 100% keyboard navigable** for shipped registry components and documented `x-ui::*` usage patterns. Treat WCAG-aligned patterns (roles, labels, focus order, keyboard traps, visible focus) as non-negotiable acceptance criteria for components in `resources/views/components/`. Playbook layout, navigation, and demo chrome are dev tooling — not held to the same bar.
