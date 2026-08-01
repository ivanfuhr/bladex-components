# Release Notes

## [Unreleased](https://github.com/ivanfuhr/stencil/compare/v0.1.0...1.x)

### Removed

- Registry item: `key-value` — use `repeater` directly for dynamic key/value rows.

### Changed

- `input` `mask` — custom pattern (`#` = digit, `A` = letter); removed `phone` / `document` presets.
- `color-picker` — compound sub-components (`trigger`, `hex`, `content`, `area`, `hue`, `dropper`, `swatches`, `swatch`) with default `shortcut`; flat `dropper` / `swatches` props compose the same parts.
- `date-picker` — panel sub-components (`panel`, `presets`, `manual-inputs`, `footer`); `withPresets`, `withInputs`, and `withConfirmation` compose those parts in shortcut mode.
- `datetime-picker` — compound sub-components (`panel`, `time-list`, `footer`) with default `shortcut`.
- `input` — `prefix` / `suffix` props now compose `input.group` + `group.prefix` / `group.suffix` instead of duplicating markup.

### Added

- Registry item: `pillbox` — tags input with `pillbox.js`, dedupe, max, and `name[]` submission.
- Registry item: `rating` — star rating input with `rating.js`.
- Registry item: `color-picker` — popover picker with SV canvas, hue slider, Tailwind swatches, hex field, and optional `dropper` (EyeDropper API).
- Repeater v1.1: `repeater.duplicate`, `repeater.handle` + `sortable`, wildcard `field.errors` for indexed keys.
- Input QoL: `mask`, `viewable`, `copyable`, `counter` via `input-enhancements.js`.
- Textarea QoL: `autosize`, `counter` via `textarea.js`.
- Combobox multiple: `multiple`, `display="count|chips"`, hidden `name[]` inputs.
- Registry item: `repeater` — composition-first dynamic array fields with `repeater.js`, add/remove rows, native `name[i][field]` submission, playbook preview, and README docs.
- Registry item: `dialog` — compound modal with `dialog.js`, alert/flyout modes, playbook preview, and README screenshots.
- Registry items: `label`, expanded `field`, `textarea`, `checkbox`, `radio`, `switch` with playbook previews and README screenshots.
- Class-based `x-ui::field` / `x-stencil::field` component for validation context propagation to slotted controls.

## [v0.1.0](https://github.com/ivanfuhr/stencil/compare/...v0.1.0) - 202x-xx-xx

Initial pre-release.
