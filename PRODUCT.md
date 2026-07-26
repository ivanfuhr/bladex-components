# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Primary audience: solo developers and small Laravel teams building custom server-rendered UIs with Blade. They need reusable UI pieces without adopting a monolithic design-system product or a framework-specific stack beyond Laravel. They publish or override views in their app, wire Tailwind, and compose interfaces from small, predictable building blocks.

## Product Purpose

BladeX Components is a Composer package that ships Blade UI components for Laravel applications. Success means consumers can install the package, publish or reference views, and assemble accessible, keyboard-complete interfaces quickly while keeping markup and styling under their control. The package stays idiomatic Laravel: service provider wiring, publish tags, config merges, translations, and a local Orchestra Testbench workbench for development and demos.

## Positioning

The product combines two proven models in one Laravel-native package:

- **shadcn-style ownership** — Tailwind-native markup consumers can publish into their app and customize (copy, theme, extend) rather than treating components as opaque black boxes.
- **Flux-style ergonomics** — A clear, composable component API (slots, compound children, minimal prop surfaces) instead of sprawling boolean and variant props.

Neighboring kits may offer one side or the other; BladeX is explicitly built to deliver both simplicity of adoption and depth of customization for Blade-first Laravel apps.

## Operating Context

- **Distribution:** Packagist package `ivanfuhr/bladex-components`, MIT license, GitHub at `ivanfuhr/bladex-components`.
- **Runtime:** PHP ^8.3, Laravel Illuminate ^12 || ^13; components render as Blade views in the host application.
- **Development:** Local workbench via `composer build` and `composer serve`; validation via `composer test` (PHPStan, Pint, Pest, type coverage).
- **Documentation & agent guidance:** README and publish tags for config, views, lang, and assets; bundled Laravel Boost skills under `resources/boost/skills/` (including composition conventions).
- **Maturity:** Early pre-release (v0.1.0); placeholder view and scaffolded package structure; usage examples in README still to be filled in.

## Capabilities and Constraints

**Confirmed today**

- Service provider registers config, views (`bladex-components::`), translations, and console publish tags.
- Composition-first conventions documented for contributors and agents (primitives, slots, compound dot-named children, `@aware`, attribute merging).
- Config currently minimal (`placeholder` default); global defaults expected to grow, not to encode component structure.

**Explicit product commitments (from maintainer)**

- Tailwind-native styling approach aligned with shadcn-like publish-and-customize workflows.
- Component API shaped toward Flux-like composability.

**Open / undecided**

- Exact component catalog and release cadence beyond initial pre-release.
- Whether default shipped themes or only structural primitives ship first.
- Formal WCAG level wording vs. the stated bar of full accessibility and full keyboard navigation (see Accessibility & Inclusion).

## Brand Commitments

- **Name:** BladeX Components (`ivanfuhr/bladex-components`).
- **Maintainer:** Ivan Führ ([GitHub](https://github.com/ivanfuhr)).
- **Tagline (package metadata):** “Powerful components for Laravel Blade.”
- **Voice:** Technical, Laravel-native, contributor-friendly; SemVer and standard open-source contribution process (see `.github/CONTRIBUTING.md`).

## Evidence on Hand

| Asset | Location / note |
| --- | --- |
| Package README, install & publish instructions | `README.md` |
| Changelog (sparse) | `CHANGELOG.md` |
| Composition & development agent skills | `resources/boost/skills/` |
| Contributing & security policies | `.github/CONTRIBUTING.md`, `.github/SECURITY.md` |
| Workbench component playbook | `workbench/routes/web.php` → `/playbook` (interactive previews) |

**Do not fabricate:** customer logos, testimonials, download benchmarks, pricing, or production case studies — none are present in the repository.

## Product Principles

1. **Composition over configuration** — Prefer slots and compound sub-components to large prop APIs; one concern per primitive.
2. **Own your markup** — Publishable, Tailwind-friendly views so consumers customize like shadcn, not fight opaque packages.
3. **Laravel-first** — Package boundaries, testing, and publishing follow Laravel package norms; no unnecessary abstractions.
4. **Accessible by default** — Components and examples must be fully accessible and fully keyboard navigable; no optional “a11y mode.”
5. **Prove in the workbench** — Observable behavior, tests, and workbench demos are the contract with consumers.

## Accessibility & Inclusion

Product bar (confirmed by maintainer): **100% accessible and 100% keyboard navigable** for shipped components and documented usage patterns. Treat WCAG-aligned patterns (roles, labels, focus order, keyboard traps, visible focus) as non-negotiable acceptance criteria for new UI; formal WCAG version/target level to be stated in component docs when the catalog grows.
