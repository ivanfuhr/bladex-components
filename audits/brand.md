# Brand — Audit

## Audit Health Score

| # | Dimension | Score | Key Finding |
|---|-----------|-------|-------------|
| 1 | Accessibility | 4 | Logo alt defaults fixed for logo-only brands |
| 2 | Performance | 4 | Static link + optional dual images |
| 3 | Theming | 3 | Dark logo swap via `dark:hidden` / `dark:block` |
| 4 | Responsive Design | 4 | `truncate` on name; compact header height |
| 5 | Anti-Patterns | 4 | Standard app mark pattern |
| **Total** | | **19/20** | **Excellent** |

## Anti-Patterns Verdict

**Pass.**

## Executive Summary

- Audit Health Score: **19/20** (Excellent)
- Issues: P0: 0, P1: 1 (fixed), P2: 0, P3: 0
- Fix applied: `Brand.php` sets `alt=""` when name is visible (decorative logo) or `__('Home')` for logo-only marks

## Detailed Findings

### Fixed (P1)

- **[P1] Missing image alternative text on logo-only brand**
  - **Location**: `src/View/Components/Brand.php`, `brand/logo-media.blade.php`
  - **Impact**: Logo-only link had no accessible name
  - **WCAG**: 1.1.1 Non-text Content
  - **Fix**: Default alt to empty when name is shown; `__('Home')` when logo-only

## Positive Findings

- Light/dark image pair support
- Custom logo slot for non-image marks (playbook “S” glyph)
- Single anchor wraps logo + name for one tab stop

## Recommended Actions

1. `/impeccable polish`
