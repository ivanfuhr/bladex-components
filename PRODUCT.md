# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Primary audience: solo developers and small Laravel teams building custom server-rendered UIs with Blade. They need reusable UI pieces without adopting a monolithic design-system product or a framework-specific stack beyond Laravel. They install components into their app, wire Tailwind, and compose interfaces from small, predictable building blocks they own.

## Product Purpose

Std Components is a **runtime Laravel package** (`composer require ivanfuhr/std-components`) that ships accessible Blade UI as PHP class components and `x-std::*` views. Consumers add `@stdScripts` and `@stdStyles` to their layout, import package Tailwind CSS, and compose interfaces from composable primitives. Success means accessible, keyboard-complete components that work out of the box without per-component JavaScript setup.

## Positioning

The product combines two proven models in one Laravel-native package:

- **shadcn-style ownership** — Tailwind-native markup copied into the app and customized (copy, theme, extend) rather than treating components as opaque black boxes.
- **Flux-style ergonomics** — A clear, composable component API (slots, compound children, minimal prop surfaces) instead of sprawling boolean and variant props.

Neighboring kits may offer one side or the other; Std Components is explicitly built to deliver both simplicity of adoption and depth of customization for Blade-first Laravel apps.

## Operating Context

- **Distribution:** Packagist package `ivanfuhr/std-components`, MIT license, GitHub at `ivanfuhr/std-components`. Installed as a normal Composer dependency; interactive JS is served from the package via `@stdScripts`.
- **CLI:** `std:icon` publishes additional Lucide icons. Registry copy-in commands (`std:init`, `std:add`, etc.) were removed.
- **Shipped to consumers:** PHP class components, Blade views, bundled `std-components.js` / `std-components.css`, and Tailwind entry CSS under `resources/css/std-components.css`.
- **Runtime (consumer app):** PHP ^8.3, Laravel Illuminate ^12 || ^13; components render as `x-std::*` Blade views in the host application.
- **Development (this repo):** Orchestra Testbench workbench via `composer build` / `composer serve`; interactive playbook at `/playbook` (`composer playbook`) for visual proof only — **not shipped** to consumers.
- **Validation:** `composer test` (PHPStan, Pint, Pest, type coverage).
- **Documentation & agent guidance:** README, publish tags for config, bundled Laravel Boost skills under `resources/boost/skills/`.
- **Maturity:** Pre-release; component catalog and playbook are functional; README documents install, layout directives, and component usage.

## Capabilities and Constraints

**Confirmed today**

- Class components + Blade views registered as `x-std::*` via `Blade::componentNamespace()`.
- `@stdScripts` / `@stdStyles` serve bundled interactive JS and base CSS from the package.
- `std:icon` publishes on-demand Lucide icons to the host app.
- Source components in `resources/views/components/` are the canonical implementation.
- Composition-first conventions documented for contributors and agents (primitives, slots, compound dot-named children, `@aware`, attribute merging).
- Tailwind v4 + class-based dark mode (`.dark` on `<html>`) via `resources/css/std-components.css`.

**Explicit product commitments**

- Tailwind-native styling with shadcn-like visual language and Flux-like composability.
- Component API shaped toward Flux-like composability.
- **Accessible by default** for shipped components — not for playbook chrome or workbench-only UI.

**Open / undecided**

- Exact component catalog and release cadence beyond current components.
- Formal WCAG level wording vs. the stated bar of full accessibility and full keyboard navigation (see Accessibility & Inclusion).

## Brand Commitments

- **Name:** Std Components (`ivanfuhr/std-components`).
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
| Registry source (legacy build artifact) | `resources/views/components/` → `composer registry:build` → `registry/` |

**Do not fabricate:** customer logos, testimonials, download benchmarks, pricing, or production case studies — none are present in the repository.

## Product Principles

1. **Composition over configuration** — Prefer slots and compound sub-components to large prop APIs; one concern per primitive.
2. **Composable primitives** — Tailwind-friendly markup with slots and compound children; customize via Blade and CSS, not opaque packages.
3. **Laravel-first** — Package boundaries, testing, and publishing follow Laravel package norms; no unnecessary abstractions.
4. **Accessible by default** — Shipped components in `resources/views/components/` must be fully accessible and fully keyboard navigable; no optional “a11y mode.” Playbook and workbench chrome are out of scope for this bar.
5. **Prove in the workbench** — Observable behavior, tests, and playbook demos validate components; playbook itself is not production UI.

## Accessibility & Inclusion

Product bar: **100% accessible and 100% keyboard navigable** for shipped components and documented `x-std::*` usage patterns. Treat WCAG-aligned patterns (roles, labels, focus order, keyboard traps, visible focus) as non-negotiable acceptance criteria for components in `resources/views/components/`. Playbook layout, navigation, and demo chrome are dev tooling — not held to the same bar.
