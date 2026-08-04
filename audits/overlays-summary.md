# Overlays Audit Summary

**Date:** 2026-08-04  
**Scope:** dialog, command, dropdown-menu, popover, tooltip  
**Playbook:** http://127.0.0.1:8001/playbook/{slug}

## Aggregate Scores

| Component | A11y | Perf | Theme | Responsive | Anti-Pattern | **Total** |
|-----------|------|------|-------|------------|--------------|-----------|
| dialog | 4 | 4 | 4 | 4 | 4 | **20/20** |
| command | 4 | 4 | 4 | 4 | 4 | **20/20** |
| dropdown-menu | 3 | 4 | 4 | 4 | 4 | **19/20** |
| popover | 4 | 3 | 4 | 4 | 4 | **19/20** |
| tooltip | 3 | 4 | 4 | 4 | 4 | **19/20** |
| **Average** | | | | | | **19.4/20** |

**Overall rating:** Excellent — overlay stack is production-ready with two targeted fixes applied.

## Issues by Severity

| Severity | Found | Fixed | Remaining |
|----------|-------|-------|-----------|
| P0 | 0 | 0 | 0 |
| P1 | 2 | 2 | 0 |
| P2 | 4 | 0 | 4 |
| P3 | 1 | 0 | 1 |

## Fixes Applied

### 1. Tooltip — keyboard focus (P1) ✅

**File:** `resources/assets/js/tooltip.js`

- Switched from `focus`/`blur` on nested control to `focusin`/`focusout` on `[data-tooltip-trigger]`
- Added `resolveControl()` + `syncDescribedBy()` so `aria-describedby` survives trigger child replacement (Alpine/Livewire remounts)

### 2. Popover — dialog naming (P1) ✅

**File:** `resources/assets/js/popover.js`

- Added `ensureAriaLabelledBy()` on open: auto-wires `aria-labelledby` to first heading (`h1–h6` or `[data-popover-title]`)

**Rebuilt:** `npm run build` (dist) + `workbench && npm run build` (playbook assets)

## Browser Verification Highlights

| Component | Keyboard | Focus trap / restore | Escape | Dark mode |
|-----------|----------|----------------------|--------|-----------|
| dialog | Tab cycle (native modal) | ✅ Native `:modal` trap; focus restored to trigger | Native cancel (automation-limited) | Tokens in blade |
| command | Arrow/Home/End/Enter; filter | ✅ Input focused on open | ✅ Closes palette | Tokens in blade |
| dropdown-menu | Arrow/Home/End; Enter | ✅ Roving focus; trigger refocus on Escape | ✅ | Tokens in blade |
| popover | Tab exits (non-modal) | ✅ First focusable on open; trigger refocus | ✅ | Tokens in blade |
| tooltip | focusin opens (fixed) | N/A (hint only) | ✅ | Inverted zinc |

## Unresolved Issues (P2/P3)

1. **dropdown-menu:** No typeahead / first-letter jump (P2)
2. **popover:** No body portal — clipping risk inside `overflow`/`transform` ancestors (P2)
3. **command:** `aria-expanded="true"` always on inline input (P2)
4. **dialog:** Preview-mode close button is decorative only (P2, intentional)
5. **dropdown-menu:** Roving focus vs `aria-activedescendant` style preference (P3)

## Test Results

| Suite | Result |
|-------|--------|
| Overlay-specific Pest tests (31) | ✅ **Passed** |
| `composer test:unit` (506) | ⚠️ **503 passed, 3 failed** — pre-existing `field/description.blade.php` syntax error (unrelated to overlays) |
| `composer test` (full) | ⚠️ **Pint check failed** — pre-existing formatting drift in unrelated files |

**Overlay tests run:**
`DialogComponentTest`, `CommandComponentTest`, `DropdownMenuComponentTest`, `PopoverComponentTest`, `TooltipComponentTest`, `SidebarComponentTest` (tooltip assertions)

## Recommended Next Steps

1. **`/impeccable layout`** — Portal popover content (parity with dropdown-menu)
2. **`/impeccable harden`** — Menu typeahead; optional command `aria-expanded` refinement
3. Fix `resources/views/components/field/description.blade.php` blade syntax (blocks 3 unrelated tests)
4. **`/impeccable polish`** — Final overlay consistency pass

## Per-Component Reports

- [dialog.md](./dialog.md)
- [command.md](./command.md)
- [dropdown-menu.md](./dropdown-menu.md)
- [popover.md](./popover.md)
- [tooltip.md](./tooltip.md)
