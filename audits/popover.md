# Popover — Impeccable Audit

## Audit Health Score

| # | Dimension | Score | Key Finding |
|---|-----------|-------|-------------|
| 1 | Accessibility | 4 | `role="dialog"`; auto `aria-labelledby` wired on open (fixed) |
| 2 | Performance | 3 | No body portal — risk of clipping in overflow ancestors |
| 3 | Theming | 4 | Zinc surface tokens; dark mode |
| 4 | Responsive Design | 4 | Fixed positioning with viewport clamp |
| 5 | Anti-Patterns | 4 | Clean anchored panel |
| **Total** | | **19/20** | **Excellent** |

**Rating band:** Excellent (minor polish)

## Anti-Patterns Verdict

**Pass.** Simple dimensions panel — appropriate product popover.

## Executive Summary

- **Audit Health Score: 19/20** (Excellent)
- **Issues:** P0: 0 · P1: 0 (1 fixed) · P2: 1 · P3: 0
- **Browser verification:** Opens on click; focus moves to first control ("Done"); Escape closes; `aria-expanded` on trigger
- **Fix applied:** `ensureAriaLabelledBy()` in `popover.js` links dialog to first heading when authors omit `aria-labelledby`

## Detailed Findings

### Fixed (was P1)

**[P1] Popover dialog missing `aria-labelledby`**
- **Location:** `resources/assets/js/popover.js`, `resources/views/components/popover/content.blade.php`
- **Category:** Accessibility
- **Impact:** Screen readers announced generic "dialog" without name
- **WCAG:** 4.1.2 Name, Role, Value
- **Fix:** Auto-assign `aria-labelledby` from first `h1–h6` or `[data-popover-title]` on open
- **Status:** ✅ Fixed

### P2

**[P2] Popover content not portaled to `<body>`**
- **Location:** `resources/assets/js/popover.js`
- **Category:** Responsive / Performance
- **Impact:** `overflow: hidden` or `transform` ancestors can clip the panel (dropdown-menu already portals)
- **Recommendation:** Mirror dropdown-menu portal pattern for popover content
- **Suggested command:** `/impeccable layout`

## Positive Findings

- Non-modal: Tab can exit; closes when focus leaves
- Outside dismiss respects nested portaled overlays (select, combobox, dropdown)
- Scroll lock while open; `createBindSignal` teardown
- `data-popover-close` helper for in-panel dismiss

## Recommended Actions

1. **`/impeccable layout`**: Portal popover content to body (parity with dropdown-menu)
2. **`/impeccable polish`**: Final overlay consistency pass
