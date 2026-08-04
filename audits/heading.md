# Audit: Heading Component

**Component:** `<x-ui::heading />`  
**Playbook:** http://127.0.0.1:8001/playbook/heading  
**Date:** 2026-08-04  
**Auditor:** impeccable audit workflow

## Audit Health Score

| # | Dimension | Score | Key Finding |
|---|-----------|-------|-------------|
| 1 | Accessibility | 4 | Semantic `h1`–`h6` via `level` prop, level-driven size scale |
| 2 | Performance | 4 | Static Blade output, no JS |
| 3 | Theming | 4 | Variant colors now apply correctly in light and dark mode (fix applied) |
| 4 | Responsive Design | 3 | rem-based scale; h4–h6 share `text-sm` step |
| 5 | Anti-Patterns | 4 | Product-native restrained typography |
| **Total** | | **19/20** | **Excellent (minor polish)** |

## Anti-Patterns Verdict

**Pass.** Fixed rem heading scale anchored to default heading level, single sans family, zinc neutrals. No display-font theatrics or decorative styling.

## Executive Summary

- **Audit Health Score:** 19/20 (Excellent — minor polish)
- **Issues:** P0: 0 · P1: 1 (fixed) · P2: 1 · P3: 1
- **Top issue (fixed):** `variant="subtle"` was overridden by hard-coded `text-zinc-950` in `stencil_heading_classes()`
- **Fixes applied:** Moved default heading colors into `stencil_text_variant_classes()`; removed trailing color override from `stencil_heading_classes()`

## Detailed Findings by Severity

### P1 (Fixed)

- **[P1] Subtle variant color overridden by base heading classes** ✅ FIXED
  - **Location:** `resources/views/ui/helpers.php` — `stencil_heading_classes()` and `stencil_text_variant_classes()`
  - **Category:** Theming / Accessibility
  - **Impact:** `variant="subtle"` rendered as full-contrast heading (`text-zinc-950`) instead of muted (`text-zinc-500`), breaking visual hierarchy and misleading developers configuring subtle section labels
  - **WCAG:** Not a contrast failure, but defeats intended hierarchy for secondary headings
  - **Fix applied:** Default heading color now lives in `stencil_text_variant_classes($variant, true)` default branch; `stencil_heading_classes()` only applies `font-semibold tracking-tight` after variant
  - **Verification:** Live preview `h2[data-heading]` with `variant=subtle` now has classes `text-zinc-500 dark:text-zinc-400` and computed color `oklch(0.705 …)` in dark mode

### P2

- **[P2] Subtle heading retains `font-semibold` weight**
  - **Location:** `resources/views/ui/helpers.php` — `stencil_heading_classes()`
  - **Category:** Anti-Pattern / Theming
  - **Impact:** Subtle headings appear bolder than subtle body text (`text` subtle has no weight bump). Secondary headings may compete with primary headings
  - **Recommendation:** Apply `font-medium` or `font-normal` when `variant="subtle"`
  - **Suggested command:** `/impeccable quieter`

### P3

- **[P3] Heading levels 4–6 collapse to same size (`text-sm`)**
  - **Location:** `resources/views/ui/helpers.php` — `stencil_heading_size_for_level()`
  - **Category:** Responsive
  - **Impact:** h5 and h6 are visually identical to h4; acceptable for product UI density but limits fine-grained hierarchy
  - **Recommendation:** Consider `text-xs` for h6 if semantic h6 usage is common in the package
  - **Suggested command:** `/impeccable typeset`

## Patterns & Systemic Issues

- Variant/color class ordering bug pattern: base color classes appended after variant classes silently override variants. Fixed for heading; text component orders correctly (variant before color).

## Positive Findings

- Semantic HTML: dynamic `h{{ $resolvedLevel }}` with clamped level 1–6
- Level-driven size scale anchored to configurable default heading level and text size
- `tracking-tight` appropriate for headings at product scale
- `data-heading` marker for potential styling/testing hooks
- Strong test coverage including level-to-size mapping matrix

## Recommended Actions

1. **[P2] `/impeccable quieter`**: Reduce weight on subtle heading variant
2. **[P3] `/impeccable typeset`**: Differentiate h5/h6 sizes if needed
3. **`/impeccable polish`**: Final consistency pass

## Browser Verification

- Light mode: default h2 preview — high contrast, semibold, `text-lg`
- Dark mode: same hierarchy on dark preview surface
- Subtle variant (post-fix): muted gray in live preview, code snippet shows `:variant="'subtle'"`

## Fixes Applied

```diff
# stencil_text_variant_classes() — default for headings now includes base color
default => $forHeading ? 'text-zinc-950 dark:text-zinc-50' : 'text-zinc-700 dark:text-zinc-300',

# stencil_heading_classes() — removed trailing color override
'font-semibold tracking-tight',  // was: 'font-semibold tracking-tight text-zinc-950 dark:text-zinc-50'
```

Test updated: `HeadingComponentTest` now asserts subtle variant does not contain `text-zinc-950`.
