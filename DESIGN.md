---
name: Stencil
description: Tailwind-native Blade UI primitives with zinc Operate tooling chrome
colors:
  primary: "#18181b"
  primary-foreground: "#fafafa"
  canvas: "#f4f4f5"
  surface: "#ffffff"
  surface-muted: "#fafafa"
  ink: "#18181b"
  ink-muted: "#71717a"
  border: "#e4e4e7"
  danger: "#dc2626"
  focus-ring: "rgba(24, 24, 27, 0.10)"
  canvas-dark: "#09090b"
  surface-dark: "#18181b"
  ink-dark: "#fafafa"
  ink-muted-dark: "#a1a1aa"
  border-dark: "#27272a"
  focus-ring-dark: "rgba(212, 212, 216, 0.20)"
typography:
  body:
    fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1rem"
    fontWeight: 400
    lineHeight: 1.5
  title:
    fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.25rem"
    fontWeight: 600
    lineHeight: 1.4
    letterSpacing: "-0.015em"
  label:
    fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.75rem"
    fontWeight: 600
    lineHeight: 1.3
    letterSpacing: "0.04em"
  mono:
    fontFamily: "ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace"
    fontSize: "0.75rem"
    fontWeight: 400
    lineHeight: 1.5
rounded:
  sm: "6px"
  md: "8px"
  lg: "12px"
  xl: "16px"
spacing:
  xs: "4px"
  sm: "8px"
  md: "16px"
  lg: "24px"
  xl: "32px"
  section: "40px"
components:
  button-primary:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.primary-foreground}"
    rounded: "{rounded.md}"
    padding: "0 16px"
    height: "36px"
  button-primary-hover:
    backgroundColor: "#27272a"
    textColor: "{colors.primary-foreground}"
  button-outline:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.ink}"
    rounded: "{rounded.md}"
    padding: "0 16px"
    height: "36px"
  playbook-card:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.ink}"
    rounded: "{rounded.xl}"
    padding: "24px"
  playbook-header:
    backgroundColor: "rgba(250, 250, 250, 0.90)"
    textColor: "{colors.ink}"
    height: "auto"
---

# Design System: Stencil

## Overview

**Creative North Star: "The Zinc Workbench"**

Stencil’s visual system is a restrained, zinc-first Operate kit for Laravel Blade. Shipped `x-ui::*` primitives and the workbench playbook share the same material language: flat tonal surfaces, hairline borders, soft one-step shadows, and Inter for both body and headings. Brand expression lives in precision (mono `x-ui::` labels, tight tracking, consistent focus rings) rather than decorative color.

The playbook chrome is **dev tooling**, not a marketing surface. It keeps the same zinc Operate look as the components: catalog cards, sticky control rails, and preview stages that feel like an IDE adjacent to the product—not a second brand.

**Key Characteristics:**
- Zinc neutral palette with near-black primary actions that invert cleanly in dark mode
- Class-based dark mode (`.dark` on `<html>`) plus `scheme-light` / `scheme-dark`
- Inter for UI type; monospace reserved for component APIs and code
- Soft elevation via `shadow-sm` + `ring-1`, not heavy layered cards
- Focus-visible rings in zinc (light) / zinc-300 (dark), never colorful default browser blue as the system accent

## Colors

A cool zinc scale carries almost all UI; semantic red is reserved for danger and invalid states.

### Primary
- **Forge Zinc** (#18181b): Primary fills, sticky emphasis, monogram mark, high-contrast text on light canvases.
- **Forge Zinc Inverse** (#fafafa): Primary text on dark fills; dark-mode primary fill.

### Neutral
- **Workbench Canvas** (#f4f4f5 / zinc-100 @ 90%): Playbook page background.
- **Panel Surface** (#ffffff): Cards, property panels, preview stages.
- **Muted Ink** (#71717a): Descriptions, mono namespace hints, secondary chrome.
- **Hairline Border** (#e4e4e7): Default separators and card edges.
- **Night Canvas** (#09090b): Dark playbook body.
- **Night Panel** (#18181b / #27272a borders): Dark surfaces and dividers.

### Named Rules
**The One Accent Rule.** Do not introduce a purple/indigo product accent for chrome or defaults. Zinc is the brand; colored accents appear only inside component demos that intentionally show palette props (avatar, badge, etc.).

## Typography

**Display Font:** Inter (with ui-sans-serif, system-ui)
**Body Font:** Inter (same stack)
**Label/Mono Font:** ui-monospace stack for `x-ui::slug` labels and code blocks

**Character:** Technical, dense, Laravel-native. One sans family for hierarchy via size and weight, not a display/body pairing.

### Hierarchy
- **Title** (600, ~1.25rem+): Page and section headings via `x-stencil::heading`.
- **Body** (400, 1rem / leading-6): Descriptions and control labels.
- **Label** (600, 0.75rem, tracked uppercase sparingly): Properties panel eyebrow, Workbench badge.
- **Mono** (400, 0.75rem): Component API crumbs and snippet panes.

### Named Rules
**The Mono-For-API Rule.** Monospace is for code and component names only—not for decorative “tech” chrome.

## Layout

Playbook shell uses a `max-w-7xl` content column with sticky top header. Component show pages are a two-column Operate layout: sticky controls (~18–20rem) + fluid preview. Catalog groups components into scanable category sections (Forms, Typography, Overlays, Feedback, Navigation, Display, Date & time)—never one undifferentiated peer grid.

Media capture pages (`/playbook/media/*`) use a fixed `--readme-media-width: 56rem` canvas with `<main id="readme-media">` for README screenshots.

Spacing rhythm: tight within cards (`gap-3`–`gap-4`), generous between catalog sections (`space-y-12`).

## Elevation & Depth

Mostly flat tonal layering. Surfaces separate with 1px zinc borders; elevation is a light `shadow-sm` and occasional `ring-1 ring-zinc-950/5`. Hover may lift catalog cards by 2px (`-translate-y-0.5`) unless `prefers-reduced-motion` is set.

### Shadow Vocabulary
- **Resting panel** (`box-shadow: 0 1px 2px rgb(0 0 0 / 0.05)` via Tailwind `shadow-sm`): Cards, stages, header controls.
- **Hover lift** (`shadow-md` + translate): Catalog cards only; disabled under reduced motion.

### Named Rules
**The Flat-By-Default Rule.** Do not stack border + wide soft glow. One border or one soft shadow is enough.

## Shapes

Corner language is soft but not pill-heavy: controls `rounded-lg` (8px), panels/cards `rounded-2xl` (16px), monogram mark `rounded-lg`. Full pills are reserved for small badges when a component opts in—not for playbook chrome navigation.

## Components

### Buttons (shipped)
- **Shape:** `rounded-lg`, height scale xs→lg (default h-9 / 36px)
- **Primary:** zinc-900 fill / zinc-50 text; dark mode inverts
- **Outline (default):** white/zinc-950 surface, zinc-200 border, shadow-sm
- **Focus:** `ring-2 ring-zinc-950/10` (+ offset on most variants)

### Playbook chrome
- **Monogram:** “S” in a 36×36 bordered tile linking home
- **Dark mode:** Global theme toggle labeled “Dark mode”; persist `stencil-playbook-dark`; FOUC-safe inline head script applies `dark` + `scheme-dark` before paint
- **Skip link:** Targets `#playbook-main` with `tabindex="-1"`
- **Preview stage:** `#playbook-canvas` with `aria-busy` while refreshing; short `aria-live` status text—not the entire canvas as a live region
- **Focus:** Logo, title, Showcase, Catalog share the same focus-visible ring vocabulary

### Cards / Catalog
- **Corner:** `rounded-2xl`
- **Background:** white / zinc-900@80 in dark
- **Border:** zinc-200/80
- **Internal padding:** 24px (`p-6`)

### Inputs / Property controls
- Native selects/checkboxes in the playbook properties panel stay neutral zinc (dev chrome), not a second accent blue system.

## Do's and Don'ts

### Do:
- **Do** keep playbook chrome on the zinc Operate system already used by `x-ui::*`.
- **Do** group catalog entries by category so recognition beats recall.
- **Do** honor `prefers-reduced-motion` for decorative hover translates.
- **Do** surface preview and clipboard failures in the short status live region.

### Don't:
- **Don't** invent a purple/indigo marketing theme for the package or playbook.
- **Don't** put `aria-live` on the entire preview canvas (announces noisy HTML churn).
- **Don't** use “BX” or any leftover monogram—canonical mark is Stencil “S”.
- **Don't** treat playbook chrome as a second product brand separate from Stencil.
