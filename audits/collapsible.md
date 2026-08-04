# Collapsible — Audit

## Audit Health Score

| # | Dimension | Score | Key Finding |
|---|-----------|-------|-------------|
| 1 | Accessibility | 4 | Button trigger + `aria-expanded`; region wiring |
| 2 | Performance | 4 | Lightweight toggle JS |
| 3 | Theming | 3 | Zinc text colors |
| 4 | Responsive Design | 4 | Inline trigger adequate for disclosure |
| 5 | Anti-Patterns | 4 | Simple disclosure, no over-decoration |
| **Total** | | **18/20** | **Excellent** |

## Anti-Patterns Verdict

**Pass.**

## Executive Summary

- Audit Health Score: **18/20** (Excellent)
- Issues: P0: 0, P1: 0, P2: 2, P3: 0
- Default `<button>` trigger: Space/Enter work natively
- `asChild` div wrapper resolves nested button controls via `resolveControl`

## Detailed Findings

- **[P2] `asChild` div trigger lacks keyboard if no nested control**
  - **Location**: `collapsible/trigger.blade.php`, `collapsible.js`
  - **Category**: Accessibility
  - **Impact**: Only when using raw div without nested button
  - **Suggested command**: `/impeccable harden`

- **[P2] Hard-coded zinc colors**
  - **Location**: `collapsible/trigger.blade.php`, `content.blade.php`
  - **Suggested command**: `/impeccable colorize`

## Positive Findings

- `inert` + `aria-hidden` on collapsed transition panels
- Open/closed `data-state` for styling hooks
- Playbook preview readable in light and dark bordered container

## Recommended Actions

1. `/impeccable harden`: Keydown handler for non-button `asChild` triggers
2. `/impeccable colorize`
3. `/impeccable polish`
