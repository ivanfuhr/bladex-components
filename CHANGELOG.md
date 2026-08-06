# Release Notes

## [Unreleased](https://github.com/ivanfuhr/std-components/compare/v0.1.0...1.x)

### Removed

- **Registry model** — `std:init`, `std:add`, `std:update`, `std:remove`, `std:list`, `std-components.json`, owned `resources/views/std` copy-in workflow.
- Registry item: `key-value` — use `repeater` directly for dynamic key/value rows.

### Changed

- **Breaking:** Package renamed from `ivanfuhr/stencil` to `ivanfuhr/std-components`. Namespace is now `Ivanfuhr\StdComponents`, Blade prefix is `x-std::*` (was `x-ui::*`), helpers/directives/events use the `std` prefix, and config/publish/asset paths use `std-components`.
- **Breaking:** Std Components is a runtime package (`composer require ivanfuhr/std-components`). Components ship as PHP class components + Blade views under `x-std::*`.
- **Breaking:** Interactive JS is served via `@stdScripts` from `/std-components/std-components.js` (esbuild bundle under `resources/assets/js` → `resources/dist/std-components.js`).
- **Breaking:** Base styles via `@stdStyles` from `/std-components/std-components.css`.
- All components register through `Blade::componentNamespace()` with class + view pairs (`src/View/Components`, `resources/views/components`).
- Tailwind entry moved to `resources/css/std-components.css` (import from vendor path in host apps).

### Added

- `scroll-area` — compound scroll region with themed overlay scrollbars (`viewport`, `scrollbar`, `thumb`, `corner`), shortcut + full composition, vertical/horizontal axes, `type` visibility modes, playbook preview, and README docs.
- `main` — shell content landmark now composes `scroll-area` (themed overlay scrollbar, `type` / `scroll-hide-delay` passthrough) instead of native `overflow-y-auto`.
- `FrontendAssets` with `@stdScripts` / `@stdStyles` directives (BladeX-style route-served assets).
- JS sources at `resources/assets/js/` with modular vanilla runtime; `npm run build` outputs `resources/dist/std-components.js`.
- Codegen scripts: `scripts/generate-component-classes.php`, `scripts/strip-blade-props.php`.

- README screenshots — added media captures for `input-currency`, `combobox`, `file-upload`, `repeater`, `pillbox`, `rating`, `color-picker`, `input-otp`, and `slider`.
- `dialog` preview — strip fixed positioning so media panels stay centered.
- `tooltip` content — `w-max whitespace-nowrap` so hints don’t collapse in narrow containers.
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
- Class-based `x-std::field` / `x-std::field` component for validation context propagation to slotted controls.

## [v0.1.0](https://github.com/ivanfuhr/std-components/compare/...v0.1.0) - 202x-xx-xx

Initial pre-release.
