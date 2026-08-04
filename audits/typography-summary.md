# Typography Category Audit Summary

**Components:** `text`, `heading`  
**Date:** 2026-08-04  
**Category total:** 38/40 (Excellent)

## Scorecard

| Component | A11y | Perf | Theming | Responsive | Anti-Patterns | Total |
|-----------|------|------|---------|------------|---------------|-------|
| **text** | 4 | 4 | 3 | 4 | 4 | **19/20** |
| **heading** | 4 | 4 | 4 | 3 | 4 | **19/20** |
| **Category** | | | | | | **38/40** |

## Issue Summary

| Severity | text | heading | Status |
|----------|------|---------|--------|
| P0 | 0 | 0 | — |
| P1 | 0 | 1 | 1 fixed |
| P2 | 1 | 1 | Open |
| P3 | 2 | 1 | Open |

## Fixes Applied

### Heading — P1: Subtle variant color override

**Problem:** `stencil_heading_classes()` appended `text-zinc-950 dark:text-zinc-50` after variant classes, so `variant="subtle"` never rendered muted colors.

**Change:** `resources/views/ui/helpers.php`
- Default heading color moved into `stencil_text_variant_classes()` (`forHeading` default branch)
- Base heading classes now only apply weight and tracking after variant

**Test:** `tests/Feature/HeadingComponentTest.php` — subtle variant must not contain `text-zinc-950`

**Browser verification:** Live preview `h2[data-heading]` with subtle variant shows `text-zinc-500 dark:text-zinc-400` and muted computed color in dark mode.

### Text — no fixes required

No P0/P1 issues identified.

## Test Results

| Suite | Result |
|-------|--------|
| `composer test:unit -- --filter='TextComponent\|HeadingComponent'` | **13 passed** (26 assertions) |
| `composer test` (full) | **Failed** on pre-existing `composer lint:check` (Pint) violations in unrelated files — not introduced by this audit |

Files flagged by Pint (pre-existing): `TextareaComponentTest.php`, `InputComponentTest.php`, several playbook blade views, scroll-area/sidebar components.

## Unresolved Issues

### P2 (recommended next pass)

1. **heading — subtle variant weight:** Subtle headings still use `font-semibold`; consider `font-medium` for parity with subtle body text (`/impeccable quieter`)
2. **text — playbook color coverage:** Playbook exposes 3 colors; helper supports 16 (`/impeccable document`)

### P3 (polish)

1. **text — prose line length:** No built-in `max-w-prose`; document consumer pattern (`/impeccable document`)
2. **text — `data-text` marker:** Undocumented attribute (`/impeccable document`)
3. **heading — h5/h6 size:** Levels 4–6 share `text-sm` (`/impeccable typeset`)

## Systemic Observation

Variant/color class ordering matters: classes appended after variants can silently override them. Heading had this bug; text orders variant before color correctly. Worth auditing other components using `stencil_text_variant_classes()`.

## Positive Highlights

- Shared typography helper layer (`stencil_text_classes`, `stencil_heading_classes`) keeps scale, font roles, and variants consistent across the package
- Semantic HTML throughout (`p`/`span`, `h1`–`h6`)
- Fixed rem scale aligned with product UI conventions (no fluid clamp headings)
- Dark mode variants on all color paths
- Strong Pest coverage for both components

## Reports

- [text.md](./text.md)
- [heading.md](./heading.md)

## Recommended Commands (priority order)

1. `/impeccable quieter` — subtle heading weight
2. `/impeccable document` — color palette and prose width docs
3. `/impeccable typeset` — h5/h6 differentiation
4. `/impeccable polish` — final pass
