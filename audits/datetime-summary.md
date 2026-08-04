# Date & Time Components — Audit Summary

**Audited:** 2026-08-04  
**Components:** calendar, date-picker, time-picker, datetime-picker  
**Playbook base:** http://127.0.0.1:8001/playbook/

## Overall Scores

| Component | A11y | Perf | Theming | Responsive | Anti-Patterns | **Total** |
|-----------|------|------|---------|------------|---------------|-----------|
| calendar | 3 | 4 | 4 | 3 | 4 | **18/20** |
| date-picker | 3 | 4 | 4 | 3 | 4 | **18/20** |
| time-picker | 3 | 4 | 4 | 3 | 4 | **18/20** |
| datetime-picker | 3 | 4 | 4 | 3 | 4 | **18/20** |
| **Average** | | | | | | **18/20** |

**Rating band:** Excellent (minor polish)

## Fixes Applied (P0/P1)

### Calendar (`calendar.js`, `calendar/index.blade.php`)
- Added `focus-visible:ring-2` to day buttons and nav buttons (prev/next/today)
- Keyboard navigation now skips disabled/unavailable dates via `findSelectableDay()`
- Grid receives `aria-label` with full month/year
- Column headers receive `aria-label` with full weekday names

### Date Picker
- Input trigger: `aria-haspopup="dialog"` and `aria-expanded` (`date-picker/input/index.blade.php`)
- JS syncs `aria-expanded` on input element when panel opens/closes (`date-picker.js`)

### Time Picker
- Input trigger: `aria-haspopup="listbox"` and `aria-expanded` (`time-picker/input/index.blade.php`)
- Time options: explicit `aria-label` and focus-visible rings (`time-picker.js`)

### Datetime Picker
- Panel: `aria-label="Select date and time"` (`datetime-picker/panel.blade.php`, `DatetimePicker/Panel.php`)
- Time options: explicit `aria-label` and focus-visible rings (`datetime-picker.js`)

## Browser Verification

- **Calendar:** ArrowRight moves focus between dates; all dates have descriptive aria-labels; dark mode tokens render correctly
- **Date picker:** Panel opens as dialog; calendar inherits keyboard nav; trigger shows `aria-expanded`
- **Time picker / datetime picker:** Listbox keyboard nav confirmed in code review; options now labeled

## Test Results

| Command | Result |
|---------|--------|
| `composer test:unit` | **506 passed** (0 failures) |
| `composer analyse` | **Passed** (0 errors) |
| `npm run build` | **Built** `resources/dist/stencil.js` |
| `composer test` (full) | **Lint check failed** — pre-existing Pint issues in unrelated files (textarea, input, playbook views, scroll-area, sidebar, etc.); not introduced by this audit |

## Unresolved Issues (P2/P3)

| Priority | Issue | Components |
|----------|-------|------------|
| P2 | Fixed 17.5rem month width may overflow on narrow viewports | calendar, date-picker, datetime-picker |
| P2 | Nested clear button inside date/time trigger buttons | date-picker, time-picker |
| P2 | Missing `aria-controls` linking trigger to panel | date-picker, time-picker, datetime-picker |
| P2 | Time list not side-by-side until `md` breakpoint | datetime-picker |
| P2 | All time options rendered in DOM (no virtualization) | time-picker, datetime-picker |
| P3 | No `role="row"` in calendar grid | calendar |
| P3 | Duplicate weekday letters (T, S) in visual headers | calendar |

## Audit Reports

- [calendar.md](./calendar.md)
- [date-picker.md](./date-picker.md)
- [time-picker.md](./time-picker.md)
- [datetime-picker.md](./datetime-picker.md)

## Recommended Next Steps

1. `/impeccable harden` — `aria-controls`, fix nested clear buttons
2. `/impeccable adapt` — fluid calendar width, earlier datetime side-by-side layout
3. `/impeccable optimize` — virtualize time lists for small step values
4. `/impeccable polish` — final visual pass across all four components
