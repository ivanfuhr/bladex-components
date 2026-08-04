# Datetime Picker — Impeccable Audit

**Component:** `datetime-picker`  
**Audited:** 2026-08-04  
**Playbook:** http://127.0.0.1:8001/playbook/datetime-picker

## Audit Health Score

| # | Dimension | Score | Key Finding |
|---|-----------|-------|-------------|
| 1 | Accessibility | 3 | Dialog + calendar + time list; panel label and option labels fixed |
| 2 | Performance | 4 | Composes calendar and time list without extra deps |
| 3 | Theming | 4 | Consistent zinc tokens across calendar and time column |
| 4 | Responsive Design | 3 | Stacked mobile layout; side-by-side on md+ |
| 5 | Anti-Patterns | 4 | Standard datetime picker composition |
| **Total** | | **18/20** | **Excellent (minor polish)** |

## Anti-Patterns Verdict

**Pass.** Calendar + time column is a familiar pattern (similar to OS datetime pickers).

## Executive Summary

- Audit Health Score: **18/20** (Excellent)
- Total issues: P0: 0, P1: 2 (fixed), P2: 2, P3: 0
- Top issues: panel lacked aria-label; time options lacked aria-labels
- Inherits calendar keyboard nav fixes

## Detailed Findings

### Fixed (P1)

- **[P1] Datetime panel missing accessible name**
  - **Location:** `resources/views/components/datetime-picker/panel.blade.php`, `DatetimePicker/Panel.php`
  - **Category:** Accessibility
  - **Impact:** Dialog opened without label for screen readers
  - **Fix applied:** Added `aria-label="{{ $panelLabel }}"` with "Select date and time"

- **[P1] Time options missing aria-label and focus-visible**
  - **Location:** `resources/assets/js/datetime-picker.js`
  - **Fix applied:** `aria-label` and focus-visible ring on each time option

### Open (P2)

- **[P2] Time list hidden on mobile below calendar with `max-h-60`**
  - **Location:** `datetime-picker/time-list.blade.php`
  - **Impact:** Usable but requires scroll; calendar and time not visible simultaneously on small screens
  - **Recommendation:** Consider side-by-side at `sm` breakpoint

- **[P2] Confirm required — no auto-close on date or time selection**
  - **Location:** `datetime-picker.js`
  - **Impact:** Extra step vs date-picker; intentional for datetime composition
  - **Recommendation:** Document in README; optional `with-confirmation="false"` prop

## Positive Findings

- Calendar focused on open for immediate keyboard date selection
- Time list has full listbox keyboard navigation
- Cancel reverts to hidden input value
- Escape restores focus to trigger
- Responsive layout with absolute time column on desktop

## Recommended Actions

1. **`/impeccable adapt`**: Earlier side-by-side breakpoint for time column
2. **`/impeccable document`**: Confirm/cancel flow in package docs
