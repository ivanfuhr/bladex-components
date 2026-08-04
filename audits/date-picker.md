# Date Picker — Impeccable Audit

**Component:** `date-picker`  
**Audited:** 2026-08-04  
**Playbook:** http://127.0.0.1:8001/playbook/date-picker

## Audit Health Score

| # | Dimension | Score | Key Finding |
|---|-----------|-------|-------------|
| 1 | Accessibility | 3 | Dialog semantics, calendar inheritance; input trigger ARIA fixed |
| 2 | Performance | 4 | Portal panel, scroll lock, deferred calendar render |
| 3 | Theming | 4 | Panel and trigger use zinc tokens with dark variants |
| 4 | Responsive Design | 3 | `max-w-[calc(100vw-2rem)]` on panel; calendar fixed width inside |
| 5 | Anti-Patterns | 4 | Standard date-picker affordance, familiar trigger + popover |
| **Total** | | **18/20** | **Excellent (minor polish)** |

## Anti-Patterns Verdict

**Pass.** Button trigger with calendar icon and chevron matches product form-control vocabulary.

## Executive Summary

- Audit Health Score: **18/20** (Excellent)
- Total issues: P0: 0, P1: 1 (fixed), P2: 2, P3: 1
- Top issue: input-type trigger lacked `aria-haspopup` / `aria-expanded`
- Calendar keyboard nav and date labels inherited from calendar fixes

## Detailed Findings

### Fixed (P1)

- **[P1] Input-type trigger missing popup ARIA attributes**
  - **Location:** `resources/views/components/date-picker/input/index.blade.php`
  - **Category:** Accessibility
  - **Impact:** Screen readers did not announce the input opens a date dialog
  - **Fix applied:** Added `aria-haspopup="dialog"` and `aria-expanded="false"`; JS syncs expanded state on open/close

### Open (P2/P3)

- **[P2] Clear button uses `role="button"` on span inside trigger button**
  - **Location:** `resources/views/components/date-picker/button.blade.php:10`
  - **Impact:** Nested interactive elements; keyboard users may tab unexpectedly
  - **Recommendation:** Move clear to sibling button outside trigger

- **[P2] No `aria-controls` linking trigger to panel**
  - **Location:** `date-picker.js`, `DatePicker/Button.php`
  - **Recommendation:** Generate stable panel id and set `aria-controls` on trigger

- **[P3] Panel uses `fixed` positioning via portal without live region for selection**
  - **Impact:** Minor; value updates in trigger text on close

## Positive Findings

- Button trigger has `aria-haspopup="dialog"` and `aria-expanded`
- Panel has `aria-label`, `role="dialog"`, `aria-modal` when open
- Escape reverts selection and restores focus to trigger
- Click-outside reverts and closes
- Embeds full calendar with all a11y improvements

## Recommended Actions

1. **`/impeccable harden`**: Add `aria-controls` and fix nested clear button
2. **`/impeccable polish`**: Range mode visual polish
