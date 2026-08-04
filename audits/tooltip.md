# Tooltip — Impeccable Audit

## Audit Health Score

| # | Dimension | Score | Key Finding |
|---|-----------|-------|-------------|
| 1 | Accessibility | 3 | Keyboard focus now opens tooltip via `focusin` (fixed) |
| 2 | Performance | 4 | Lightweight; fixed positioning only when open |
| 3 | Theming | 4 | Inverted zinc in dark mode |
| 4 | Responsive Design | 4 | Viewport clamping on all sides |
| 5 | Anti-Patterns | 4 | Minimal hint surface |
| **Total** | | **19/20** | **Excellent** |

**Rating band:** Excellent (minor polish)

## Anti-Patterns Verdict

**Pass.** Small, functional hint — not decorative noise.

## Executive Summary

- **Audit Health Score: 19/20** (Excellent)
- **Issues:** P0: 0 · P1: 1 (fixed) · P2: 1 · P3: 0
- **Browser verification:** Hover opens after delay; `aria-describedby` on control; Escape closes; dark mode tokens verified in code
- **Fix applied:** Replaced per-button `focus`/`blur` listeners with `focusin`/`focusout` on trigger wrapper

## Detailed Findings

### Fixed (was P1)

**[P1] Tooltip did not open on keyboard focus**
- **Location:** `resources/assets/js/tooltip.js`
- **Category:** Accessibility
- **Impact:** Keyboard and screen-reader users did not receive tooltip text when focusing the trigger control; especially broken when Alpine/Livewire replaces inner button nodes while trigger wrapper persists
- **WCAG:** 1.3.1 Info and Relationships; 4.1.2 Name, Role, Value
- **Root cause:** `focus` listener bound to nested `button` at init time; DOM replacement left hover (`pointerenter` on trigger) working but focus handler orphaned
- **Fix:** `focusin`/`focusout` on `[data-tooltip-trigger]` + dynamic `resolveControl()` for `aria-describedby`
- **Status:** ✅ Fixed

### P2

**[P2] Tooltip uses `role="tooltip"` while referenced via `aria-describedby`**
- **Location:** `resources/views/components/tooltip/content.blade.php`
- **Category:** Accessibility
- **Impact:** Valid pattern; some AT combinations prefer description-only without tooltip role when not hover-only
- **Recommendation:** Monitor; current pattern matches common design-system practice
- **Suggested command:** `/impeccable harden`

## Positive Findings

- Hover delay configurable via `data-delay`
- Sidebar icon-mode gating (`data-sidebar-menu-tooltip`)
- `pointer-events-none` on content; no layout shift (measure off-screen)
- Escape dismiss on root

## Recommended Actions

1. **`/impeccable harden`**: Evaluate tooltip role vs description-only for SR-only hints
2. **`/impeccable polish`**: Final overlay consistency pass
