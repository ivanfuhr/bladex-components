<?php

declare(strict_types=1);
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\ComponentAttributeBag;

if (! function_exists('stencil_typography_defaults')) {
    function stencil_typography_defaults(): array
    {
        return [
            'scale' => [
                'sm' => ['text' => 'text-sm', 'leading' => 'leading-5'],
                'default' => ['text' => 'text-base', 'leading' => 'leading-6'],
                'lg' => ['text' => 'text-lg', 'leading' => 'leading-7'],
                'xl' => ['text' => 'text-xl', 'leading' => 'leading-8'],
            ],
            'fonts' => [
                'sans' => [
                    'provider' => 'google',
                    'family' => 'Inter',
                    'weights' => [400, 500, 600, 700],
                    'subsets' => ['latin'],
                    'fallback' => 'ui-sans-serif, system-ui, sans-serif',
                ],
            ],
            'roles' => [
                'body' => 'sans',
                'heading' => 'sans',
            ],
            'defaults' => [
                'text_size' => 'default',
                'heading_level' => 2,
            ],
        ];
    }
}

if (! function_exists('stencil_merge_typography_config')) {
    function stencil_merge_typography_config(array $base, array $override): array
    {
        $merged = array_replace_recursive($base, $override);

        if (array_key_exists('fonts', $override)) {
            $merged['fonts'] = $override['fonts'];
        }

        return $merged;
    }
}

if (! function_exists('stencil_typography_config')) {
    function stencil_typography_config(): array
    {
        $config = stencil_typography_defaults();

        $vendorTypography = config('stencil.typography', []);

        if (is_array($vendorTypography) && $vendorTypography !== []) {
            $config = stencil_merge_typography_config($config, $vendorTypography);
        }

        return $config;
    }

    function stencil_typography_scale(): array
    {
        $defaults = [
            'sm' => ['text' => 'text-sm', 'leading' => 'leading-5'],
            'default' => ['text' => 'text-base', 'leading' => 'leading-6'],
            'lg' => ['text' => 'text-lg', 'leading' => 'leading-7'],
            'xl' => ['text' => 'text-xl', 'leading' => 'leading-8'],
        ];
        $scale = stencil_typography_config()['scale'] ?? [];
        $merged = [];

        foreach ($defaults as $key => $default) {
            $entry = is_array($scale[$key] ?? null) ? $scale[$key] : [];
            $merged[$key] = [
                'text' => (string) ($entry['text'] ?? $default['text']),
                'leading' => (string) ($entry['leading'] ?? $default['leading']),
            ];
        }

        return $merged;
    }

    function stencil_typography_size_classes(?string $size): string
    {
        $keys = ['sm', 'default', 'lg', 'xl'];
        $key = $size === null || $size === '' ? 'default' : $size;

        if (! in_array($key, $keys, true)) {
            $key = 'default';
        }

        $entry = stencil_typography_scale()[$key];

        return trim("{$entry['text']} {$entry['leading']}");
    }

    function stencil_typography_step_up(string $size): string
    {
        $order = ['sm', 'default', 'lg', 'xl'];
        $index = array_search($size, $order, true) ?: 1;

        return $order[min(count($order) - 1, $index + 1)];
    }

    function stencil_typography_step_down(string $size): string
    {
        $order = ['sm', 'default', 'lg', 'xl'];
        $index = array_search($size, $order, true) ?: 1;

        return $order[max(0, $index - 1)];
    }

    function stencil_font_role_class(string $role): string
    {
        $roles = stencil_typography_config()['roles'] ?? [];
        $fonts = stencil_typography_config()['fonts'] ?? [];
        $fontKeys = array_keys(is_array($fonts) ? $fonts : []);
        $body = (string) ($roles['body'] ?? 'sans');
        $heading = (string) ($roles['heading'] ?? 'sans');

        if ($heading !== '' && ! in_array($heading, $fontKeys, true)) {
            $heading = in_array('sans', $fontKeys, true) ? 'sans' : ($fontKeys[0] ?? $body);
        }

        if ($body !== '' && ! in_array($body, $fontKeys, true)) {
            $body = $fontKeys[0] ?? 'sans';
        }

        $key = $role === 'heading' ? $heading : $body;

        return "font-[family-name:var(--font-{$key})]";
    }

    function stencil_default_text_size(): string
    {
        $defaults = stencil_typography_config()['defaults'] ?? [];
        $size = (string) ($defaults['text_size'] ?? 'default');

        return in_array($size, ['sm', 'default', 'lg', 'xl'], true) ? $size : 'default';
    }

    function stencil_default_heading_level(): int
    {
        $defaults = stencil_typography_config()['defaults'] ?? [];
        $level = (int) ($defaults['heading_level'] ?? 2);

        return max(1, min(6, $level));
    }

    function stencil_input_control_classes(?string $inputSize): string
    {
        $scaleSize = $inputSize === 'sm' ? 'sm' : 'default';
        $fileText = stencil_typography_scale()['sm']['text'];

        return collect([
            stencil_typography_size_classes($scaleSize),
            stencil_font_role_class('body'),
            'text-zinc-950 dark:text-zinc-50',
            "file:border-0 file:bg-transparent file:{$fileText} file:font-medium file:text-zinc-950 dark:file:text-zinc-50",
        ])->implode(' ');
    }

    function stencil_button_label_classes(?string $buttonSize): string
    {
        $scaleSize = match ($buttonSize) {
            'xs', 'sm' => 'sm',
            'lg' => 'lg',
            default => 'sm',
        };

        return collect([
            $buttonSize === 'xs' ? 'text-xs leading-4' : stencil_typography_size_classes($scaleSize),
            stencil_font_role_class('body'),
            'font-medium',
        ])->implode(' ');
    }

    function stencil_text_variant_classes(?string $variant, bool $forHeading): string
    {
        return match ($variant) {
            'strong' => 'font-semibold text-zinc-950 dark:text-zinc-50',
            'subtle' => 'text-zinc-500 dark:text-zinc-400',
            'error' => 'text-red-600 dark:text-red-400',
            default => $forHeading ? '' : 'text-zinc-700 dark:text-zinc-300',
        };
    }

    function stencil_text_color_classes(?string $color): string
    {
        if ($color === null || $color === '' || $color === 'default') {
            return '';
        }

        $palette = [
            'red', 'orange', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan',
            'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose',
        ];

        if (! in_array($color, $palette, true)) {
            return '';
        }

        return "text-{$color}-600 dark:text-{$color}-400";
    }

    function stencil_heading_size_for_level(int $level): string
    {
        $normalized = max(1, min(6, $level));
        $anchorLevel = stencil_default_heading_level();
        $anchorSize = stencil_typography_step_up(stencil_default_text_size());
        $offset = $anchorLevel - $normalized;
        $size = $anchorSize;

        if ($offset > 0) {
            for ($i = 0; $i < $offset; $i++) {
                $size = stencil_typography_step_up($size);
            }
        } elseif ($offset < 0) {
            for ($i = 0; $i < abs($offset); $i++) {
                $size = stencil_typography_step_down($size);
            }
        }

        return $size;
    }

    function stencil_heading_classes(int $level, ?string $variant = null): string
    {
        return collect([
            'heading',
            stencil_typography_size_classes(stencil_heading_size_for_level($level)),
            stencil_font_role_class('heading'),
            stencil_text_variant_classes($variant, true),
            'font-semibold tracking-tight text-zinc-950 dark:text-zinc-50',
        ])->filter()->implode(' ');
    }

    function stencil_text_classes(?string $size, ?string $variant, ?string $color): string
    {
        return collect([
            'text',
            stencil_typography_size_classes($size),
            stencil_font_role_class('body'),
            stencil_text_variant_classes($variant, false),
            stencil_text_color_classes($color),
        ])->filter()->implode(' ');
    }

    function stencil_cursor_classes(string $cursor): string
    {
        return match ($cursor) {
            'pointer' => 'cursor-pointer',
            'default' => 'cursor-default',
            default => 'cursor-text',
        };
    }

    function stencil_interaction_classes(bool $includeReadOnly = true): string
    {
        return collect([
            'disabled:cursor-not-allowed disabled:opacity-50',
            'aria-disabled:cursor-not-allowed',
            'data-loading:pointer-events-none data-loading:cursor-wait data-loading:opacity-70',
            'aria-busy:pointer-events-none aria-busy:cursor-wait aria-busy:opacity-70',
            $includeReadOnly
                ? 'read-only:cursor-default read-only:bg-zinc-50 read-only:opacity-100 dark:read-only:bg-zinc-900/50'
                : null,
        ])->filter()->implode(' ');
    }

    function stencil_is_attribute_active(ComponentAttributeBag $attributes, string $key): bool
    {
        if (! $attributes->offsetExists($key)) {
            return false;
        }

        $value = $attributes->get($key);

        return ! in_array($value, [false, 'false', 0, '0', null], true);
    }

    function stencil_is_loading(ComponentAttributeBag $attributes): bool
    {
        if (stencil_is_attribute_active($attributes, 'data-loading')) {
            return true;
        }

        if (! $attributes->offsetExists('aria-busy')) {
            return false;
        }

        $value = $attributes->get('aria-busy');

        return ! in_array($value, [false, 'false', 0, '0', null, ''], true);
    }

    function stencil_apply_interaction(
        ComponentAttributeBag $attributes,
        bool $nativeDisabled = true,
        ?bool $loading = null,
    ): ComponentAttributeBag {
        if ($loading === true) {
            $attributes = $attributes->merge(['data-loading' => true]);
        }

        if (stencil_is_loading($attributes)) {
            $attributes = $attributes->merge(['aria-busy' => 'true']);
        }

        $disabled = stencil_is_attribute_active($attributes, 'disabled')
            || stencil_is_attribute_active($attributes, 'aria-disabled');

        if (! $nativeDisabled && $disabled) {
            return $attributes
                ->except('disabled')
                ->merge([
                    'aria-disabled' => 'true',
                    'tabindex' => '-1',
                ]);
        }

        return $attributes;
    }

    function stencil_field_surface_classes(?string $size, bool $includeReadOnly = true, string $cursor = 'text'): string
    {
        return collect([
            'rounded-md border border-zinc-200 bg-white px-3 py-1 shadow-sm transition-colors',
            stencil_cursor_classes($cursor),
            stencil_input_control_classes($size),
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-0',
            stencil_interaction_classes($includeReadOnly),
            'dark:border-zinc-800 dark:bg-zinc-950',
            'dark:focus-visible:ring-zinc-300/20',
            $size === 'sm' ? 'h-8 px-2.5' : 'h-9',
        ])->implode(' ');
    }

    function stencil_textarea_surface_classes(?string $size, bool $includeReadOnly = true): string
    {
        return collect([
            'rounded-md border border-zinc-200 bg-white px-3 py-2 shadow-sm transition-colors',
            stencil_cursor_classes('text'),
            stencil_input_control_classes($size),
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-0',
            stencil_interaction_classes($includeReadOnly),
            'dark:border-zinc-800 dark:bg-zinc-950',
            'dark:focus-visible:ring-zinc-300/20',
            'min-h-[5rem] w-full resize-y',
            $size === 'sm' ? 'min-h-[4rem] px-2.5' : null,
        ])->filter()->implode(' ');
    }

    function stencil_label_classes(): string
    {
        return collect([
            stencil_text_classes('sm', 'strong', null),
            'text-zinc-950 dark:text-zinc-50',
        ])->implode(' ');
    }

    function stencil_choice_control_classes(string $type = 'checkbox', ?string $size = null): string
    {
        $dimension = $size === 'sm' ? 'size-3.5' : 'size-4';
        $rounded = $type === 'radio' ? 'rounded-full' : 'rounded-[4px]';

        return collect([
            'choice-control',
            $dimension,
            'shrink-0',
            $rounded,
            'border border-zinc-300 bg-white shadow-sm transition-colors',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-2 focus-visible:ring-offset-white',
            'disabled:cursor-not-allowed disabled:opacity-50',
            'dark:border-zinc-600 dark:bg-zinc-950 dark:focus-visible:ring-zinc-300/20 dark:focus-visible:ring-offset-zinc-950',
            'aria-invalid:border-red-500 aria-invalid:ring-red-500/20',
            'dark:aria-invalid:border-red-500',
        ])->implode(' ');
    }

    function stencil_checkbox_control_classes(?string $size = null): string
    {
        // checked:bg-* must live in scanned Support/helpers sources — View/Components is not @source'd.
        return collect([
            stencil_choice_control_classes('checkbox', $size),
            'appearance-none',
            'checked:border-zinc-900 checked:bg-zinc-900',
            'dark:checked:border-zinc-50 dark:checked:bg-zinc-50',
        ])->implode(' ');
    }

    function stencil_radio_control_classes(?string $size = null): string
    {
        return collect([
            stencil_choice_control_classes('radio', $size),
            'appearance-none',
            'checked:border-zinc-900',
            'dark:checked:border-zinc-50',
        ])->implode(' ');
    }

    function stencil_switch_root_classes(?string $size = null): string
    {
        return collect([
            'inline-flex shrink-0 items-center justify-center',
            $size === 'sm' ? 'h-8' : 'h-9',
        ])->implode(' ');
    }

    function stencil_switch_track_classes(?string $size = null): string
    {
        $track = $size === 'sm' ? 'h-5 w-9' : 'h-6 w-11';

        return collect([
            'switch__track',
            'relative inline-flex shrink-0 items-center rounded-full p-0.5 transition-colors',
            $track,
        ])->implode(' ');
    }

    function stencil_switch_thumb_classes(?string $size = null): string
    {
        $thumb = $size === 'sm' ? 'size-4' : 'size-5';

        return collect([
            'switch__thumb',
            'pointer-events-none block rounded-full bg-white shadow-lg ring-0 transition-transform',
            $thumb,
            'dark:bg-zinc-950',
        ])->implode(' ');
    }

    function stencil_slider_root_classes(?string $size = null): string
    {
        return collect([
            'slider relative flex w-full touch-none select-none items-center',
            $size === 'sm' ? 'h-8' : 'h-9',
        ])->implode(' ');
    }

    function stencil_slider_track_classes(?string $size = null): string
    {
        $height = $size === 'sm' ? 'h-1' : 'h-1.5';

        return collect([
            'slider__track',
            'relative w-full grow overflow-hidden rounded-full',
            $height,
            'bg-zinc-200 dark:bg-zinc-800',
        ])->implode(' ');
    }

    function stencil_slider_range_classes(): string
    {
        return 'slider__range absolute h-full rounded-full bg-zinc-900 dark:bg-zinc-50';
    }

    function stencil_slider_thumb_classes(?string $size = null): string
    {
        $thumb = $size === 'sm' ? 'size-3.5' : 'size-4';

        return collect([
            'slider__thumb',
            'absolute top-1/2 block -translate-x-1/2 -translate-y-1/2 rounded-full border border-zinc-200 bg-white shadow-sm transition-colors',
            $thumb,
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-2 focus-visible:ring-offset-white',
            'disabled:pointer-events-none disabled:opacity-50',
            'aria-disabled:pointer-events-none aria-disabled:opacity-50',
            'dark:border-zinc-800 dark:bg-zinc-50',
            'dark:focus-visible:ring-zinc-300/20 dark:focus-visible:ring-offset-zinc-950',
            'aria-invalid:border-red-500 aria-invalid:ring-red-500/20',
            'dark:aria-invalid:border-red-500',
            stencil_cursor_classes('pointer'),
        ])->implode(' ');
    }

    function stencil_invalid_field_classes(): string
    {
        return implode(' ', [
            'aria-invalid:border-red-500 aria-invalid:text-red-950 aria-invalid:placeholder:text-red-400',
            'aria-invalid:focus-visible:ring-red-500/20',
            'dark:aria-invalid:border-red-500 dark:aria-invalid:text-red-50',
        ]);
    }

    function stencil_select_listbox_classes(?string $size): string
    {
        return collect([
            'z-[200] flex max-h-60 min-w-[8rem] flex-col gap-1 overflow-y-auto overflow-x-hidden rounded-md border border-zinc-200 bg-white p-1 shadow-md',
            stencil_input_control_classes($size),
            'text-zinc-950 focus:outline-none',
            'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
        ])->implode(' ');
    }

    function stencil_select_option_classes(?string $size): string
    {
        return collect([
            'relative flex w-full select-none items-center gap-2 rounded-sm py-1.5 pl-2 pr-8 outline-none',
            stencil_cursor_classes('pointer'),
            stencil_text_classes($size === 'sm' ? 'sm' : null, null, null),
            'text-zinc-950 dark:text-zinc-50',
            'hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
            'data-[highlighted]:bg-zinc-100 data-[highlighted]:text-zinc-900',
            'dark:data-[highlighted]:bg-zinc-800 dark:data-[highlighted]:text-zinc-50',
            'data-[disabled]:pointer-events-none data-[disabled]:cursor-not-allowed data-[disabled]:opacity-50',
            $size === 'sm' ? 'py-1' : null,
        ])->filter()->implode(' ');
    }

    function stencil_normalize_button_variant(?string $variant): string
    {
        $variant = $variant ?? 'outline';

        return match ($variant) {
            'destructive' => 'danger',
            'default' => 'primary',
            default => $variant,
        };
    }

    function stencil_normalize_button_size(?string $size): string
    {
        $size = $size ?? 'default';

        return match ($size) {
            'base' => 'default',
            default => $size,
        };
    }

    function stencil_button_size_classes(
        string $size,
        bool $square,
        bool $iconOnly,
        bool $hasLeading,
        bool $hasTrailing,
    ): string {
        $iconOnly = $iconOnly || ($square && ! $hasLeading && ! $hasTrailing);

        if ($iconOnly || $square) {
            return match ($size) {
                'xs' => 'size-7 [&_[data-icon]]:size-3.5',
                'sm' => 'size-8 [&_[data-icon]]:size-3.5',
                'lg' => 'size-10 [&_[data-icon]]:size-5',
                default => 'size-9 [&_[data-icon]]:size-4',
            };
        }

        $height = match ($size) {
            'xs' => 'h-7 px-2.5',
            'sm' => 'h-8 px-3',
            'lg' => 'h-10 px-6',
            default => 'h-9 px-4',
        };

        $iconSize = match ($size) {
            'xs' => '[&_[data-icon]]:size-3.5',
            'lg' => '[&_[data-icon]]:size-5',
            default => '[&_[data-icon]]:size-4',
        };

        return collect([$height, $iconSize])->implode(' ');
    }

    function stencil_button_primary_classes(?string $color): string
    {
        $palette = [
            'zinc', 'red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan',
            'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose',
        ];
        $color = $color !== null && $color !== '' ? strtolower($color) : 'zinc';

        if ($color === 'zinc' || ! in_array($color, $palette, true)) {
            return implode(' ', [
                'border border-transparent bg-zinc-900 text-zinc-50 shadow-sm ring-1 ring-white/15',
                'hover:bg-zinc-800 hover:ring-white/25',
                'dark:bg-zinc-50 dark:text-zinc-900 dark:ring-zinc-950/10 dark:hover:bg-zinc-200',
            ]);
        }

        return implode(' ', [
            'border border-transparent text-white shadow-sm',
            "bg-{$color}-600 hover:bg-{$color}-700",
            'focus-visible:ring-'.$color.'-600/25 dark:focus-visible:ring-'.$color.'-400/30',
            "dark:bg-{$color}-600 dark:hover:bg-{$color}-500",
        ]);
    }

    function stencil_button_variant_classes(string $variant, ?string $color): string
    {
        return match ($variant) {
            'primary', 'filled' => stencil_button_primary_classes($color),
            'secondary' => implode(' ', [
                'border border-transparent bg-zinc-100 text-zinc-900 shadow-sm',
                'hover:bg-zinc-200/90',
                'dark:bg-zinc-800 dark:text-zinc-50 dark:hover:bg-zinc-700/90',
            ]),
            'danger' => implode(' ', [
                'border border-transparent bg-red-600 text-white shadow-sm',
                'hover:bg-red-700',
                'focus-visible:ring-red-600/20 dark:focus-visible:ring-red-400/30',
                'dark:bg-red-600 dark:hover:bg-red-500',
            ]),
            'ghost' => implode(' ', [
                'border border-transparent bg-transparent text-current shadow-none',
                'hover:bg-zinc-100 hover:text-zinc-900',
                'dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
            ]),
            'subtle' => implode(' ', [
                'border border-transparent bg-zinc-100/80 text-zinc-900 shadow-none',
                'hover:bg-zinc-200/80',
                'dark:bg-zinc-800/80 dark:text-zinc-50 dark:hover:bg-zinc-800',
            ]),
            'link' => implode(' ', [
                'h-auto border-0 bg-transparent p-0 text-zinc-900 shadow-none',
                'hover:underline',
                'focus-visible:ring-offset-0',
                'dark:text-zinc-50',
            ]),
            default => implode(' ', [
                'border border-zinc-200 bg-white text-zinc-900 shadow-sm',
                'hover:bg-zinc-50',
                'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50 dark:hover:bg-zinc-900',
            ]),
        };
    }

    function stencil_button_classes(
        ?string $variant = null,
        ?string $size = null,
        ?string $color = null,
        array $options = [],
    ): string {
        $variant = stencil_normalize_button_variant($variant);
        $size = stencil_normalize_button_size($size);
        $hasLeading = (bool) ($options['hasLeading'] ?? false);
        $hasTrailing = (bool) ($options['hasTrailing'] ?? false);
        $square = (bool) ($options['square'] ?? false);
        $iconOnly = (bool) ($options['iconOnly'] ?? false);

        return collect([
            'button',
            'inline-flex shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-md',
            $variant !== 'link' ? stencil_button_label_classes($size) : stencil_button_label_classes($size).' underline-offset-4',
            'transition-colors',
            $variant !== 'link' ? 'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-zinc-300/20 dark:focus-visible:ring-offset-zinc-950' : 'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus-visible:ring-zinc-300/20',
            stencil_interaction_classes(),
            'cursor-pointer aria-disabled:pointer-events-none aria-disabled:cursor-not-allowed',
            '[&_svg]:pointer-events-none [&_svg]:shrink-0',
            $variant !== 'link' ? stencil_button_size_classes($size, $square, $iconOnly, $hasLeading, $hasTrailing) : null,
            stencil_button_variant_classes($variant, $color),
        ])->filter()->implode(' ');
    }

    function stencil_normalize_icon_variant(string $variant): string
    {
        if ($variant === 'solid') {
            return 'outline';
        }

        if (in_array($variant, ['outline', 'mini', 'micro'], true)) {
            return $variant;
        }

        return 'outline';
    }

    function stencil_icon_variant_resolve(string $variant): array
    {
        $normalized = stencil_normalize_icon_variant($variant);

        return match ($normalized) {
            'mini' => ['size-5', '2.25', 20],
            'micro' => ['size-3', '2.5', 12],
            default => ['size-4', '2', 16],
        };
    }

    function stencil_icon_variant_class_string(string $variant): string
    {
        [$sizeClass] = stencil_icon_variant_resolve($variant);

        return "block shrink-0 {$sizeClass}";
    }

    function stencil_normalize_icon_name(string $name): string
    {
        $trimmed = trim($name);

        if ($trimmed === '') {
            throw new InvalidArgumentException('Icon name cannot be empty.');
        }

        $normalized = strtolower(str_replace('_', '-', $trimmed));

        if (! preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $normalized)) {
            throw new InvalidArgumentException("Invalid icon name [{$name}]. Use kebab-case names from lucide.dev/icons.");
        }

        return $normalized;
    }

    function stencil_resolved_icons_path(): string
    {
        return dirname(__DIR__).'/icons';
    }

    function stencil_google_fonts_url(): ?string
    {
        $fonts = stencil_typography_config()['fonts'] ?? [];

        if (! is_array($fonts)) {
            return null;
        }

        $families = [];

        foreach ($fonts as $key => $definition) {
            if (! is_array($definition)) {
                continue;
            }

            if ((string) ($definition['provider'] ?? '') !== 'google') {
                continue;
            }

            $family = (string) ($definition['family'] ?? '');

            if ($family === '') {
                continue;
            }

            $weights = $definition['weights'] ?? [400];

            if (! is_array($weights)) {
                $weights = [400];
            }

            sort($weights);
            $weightList = implode(';', array_map(strval(...), $weights));
            $encodedFamily = str_replace(' ', '+', $family);
            $families[] = "family={$encodedFamily}:wght@{$weightList}";
        }

        if ($families === []) {
            return null;
        }

        return 'https://fonts.googleapis.com/css2?'.implode('&', $families).'&display=swap';
    }

    function stencil_css_font_variables(): array
    {
        $fonts = stencil_typography_config()['fonts'] ?? [];
        $variables = [];

        if (! is_array($fonts)) {
            return $variables;
        }

        foreach ($fonts as $key => $definition) {
            if (! is_array($definition)) {
                continue;
            }

            $family = (string) ($definition['family'] ?? '');

            if ($family === '') {
                continue;
            }

            $fallback = (string) ($definition['fallback'] ?? 'ui-sans-serif, system-ui, sans-serif');
            $variables[(string) $key] = "'{$family}', {$fallback}";
        }

        return $variables;
    }

    function stencil_resolve_timezone(?string $timezone): string
    {
        if (filled($timezone)) {
            return $timezone;
        }

        return (string) config('app.timezone', 'UTC');
    }

    function stencil_to_date_string(mixed $value): string
    {
        if ($value instanceof Carbon) {
            return $value->format('Y-m-d');
        }

        return Carbon::parse($value)->format('Y-m-d');
    }

    function stencil_normalize_date_value(mixed $value, string $mode = 'single'): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_array($value)) {
            if ($mode === 'range') {
                $start = $value['start'] ?? null;
                $end = $value['end'] ?? null;

                if (filled($start) && filled($end)) {
                    return stencil_to_date_string($start).'/'.stencil_to_date_string($end);
                }

                return null;
            }

            return collect($value)->filter()->map(fn (mixed $v) => stencil_to_date_string($v))->implode(',');
        }

        return is_string($value) ? $value : stencil_to_date_string($value);
    }

    function stencil_normalize_datetime_value(mixed $value, ?string $timezone = null): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $tz = stencil_resolve_timezone($timezone);

        if (is_string($value)) {
            return Carbon::parse($value, $tz)->toIso8601String();
        }

        if ($value instanceof Carbon) {
            return $value->copy()->timezone($tz)->toIso8601String();
        }

        return null;
    }

    function stencil_normalize_time_value(mixed $value, bool $withSeconds = false): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_array($value)) {
            $value = collect($value)->first();
        }

        if (! is_string($value)) {
            return null;
        }

        $parts = explode(':', $value);

        if (count($parts) === 2) {
            return $withSeconds ? $value.':00' : $value;
        }

        if (count($parts) === 3) {
            return $withSeconds ? $value : implode(':', array_slice($parts, 0, 2));
        }

        return $value;
    }

    function stencil_date_preset_label(string $key): string
    {
        return match ($key) {
            'today' => __('Today'),
            'yesterday' => __('Yesterday'),
            'thisWeek' => __('This Week'),
            'lastWeek' => __('Last Week'),
            'last7Days' => __('Last 7 Days'),
            'thisMonth' => __('This Month'),
            'lastMonth' => __('Last Month'),
            'thisQuarter' => __('This Quarter'),
            'lastQuarter' => __('Last Quarter'),
            'thisYear' => __('This Year'),
            'lastYear' => __('Last Year'),
            'last14Days' => __('Last 14 Days'),
            'last30Days' => __('Last 30 Days'),
            'last3Months' => __('Last 3 Months'),
            'last6Months' => __('Last 6 Months'),
            'yearToDate' => __('Year to Date'),
            'tomorrow' => __('Tomorrow'),
            'nextWeek' => __('Next Week'),
            'next7Days' => __('Next 7 Days'),
            'nextMonth' => __('Next Month'),
            'nextQuarter' => __('Next Quarter'),
            'nextYear' => __('Next Year'),
            'next14Days' => __('Next 14 Days'),
            'next30Days' => __('Next 30 Days'),
            'next3Months' => __('Next 3 Months'),
            'next6Months' => __('Next 6 Months'),
            'allTime' => __('All Time'),
            'custom' => __('Custom'),
            default => $key,
        };
    }

    function stencil_date_preset_dates(string $key, ?Carbon $allTimeStart = null): ?array
    {
        $now = Carbon::now();

        return match ($key) {
            'today' => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
            'yesterday' => [$now->copy()->subDay()->startOfDay(), $now->copy()->subDay()->endOfDay()],
            'thisWeek' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'lastWeek' => [$now->copy()->subWeek()->startOfWeek(), $now->copy()->subWeek()->endOfWeek()],
            'last7Days' => [$now->copy()->subDays(7)->addDay()->startOfDay(), $now->copy()->endOfDay()],
            'thisMonth' => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
            'lastMonth' => [$now->copy()->startOfMonth()->subMonth(), $now->copy()->startOfMonth()->subMonth()->endOfMonth()],
            'thisQuarter' => [$now->copy()->startOfQuarter(), $now->copy()->endOfQuarter()],
            'lastQuarter' => [$now->copy()->subQuarter()->startOfQuarter(), $now->copy()->subQuarter()->endOfQuarter()],
            'thisYear' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            'lastYear' => [$now->copy()->subYear()->startOfYear(), $now->copy()->subYear()->endOfYear()],
            'last14Days' => [$now->copy()->subDays(14)->addDay()->startOfDay(), $now->copy()->endOfDay()],
            'last30Days' => [$now->copy()->subDays(30)->addDay()->startOfDay(), $now->copy()->endOfDay()],
            'last3Months' => [$now->copy()->subMonths(3)->addDay()->startOfDay(), $now->copy()->endOfDay()],
            'last6Months' => [$now->copy()->subMonths(6)->addDay()->startOfDay(), $now->copy()->endOfDay()],
            'yearToDate' => [$now->copy()->startOfYear(), $now->copy()->endOfDay()],
            'tomorrow' => [$now->copy()->addDay()->startOfDay(), $now->copy()->addDay()->endOfDay()],
            'nextWeek' => [$now->copy()->addWeek()->startOfWeek(), $now->copy()->addWeek()->endOfWeek()],
            'next7Days' => [$now->copy()->startOfDay(), $now->copy()->addDays(6)->endOfDay()],
            'nextMonth' => [$now->copy()->endOfMonth()->addDay()->startOfDay(), $now->copy()->endOfMonth()->addDay()->endOfMonth()->endOfDay()],
            'nextQuarter' => [$now->copy()->addQuarter()->startOfQuarter(), $now->copy()->addQuarter()->endOfQuarter()],
            'nextYear' => [$now->copy()->addYear()->startOfYear(), $now->copy()->addYear()->endOfYear()],
            'next14Days' => [$now->copy()->startOfDay(), $now->copy()->addDays(13)->endOfDay()],
            'next30Days' => [$now->copy()->startOfDay(), $now->copy()->addDays(29)->endOfDay()],
            'next3Months' => [$now->copy()->startOfDay(), $now->copy()->addMonths(3)->subDay()->endOfDay()],
            'next6Months' => [$now->copy()->startOfDay(), $now->copy()->addMonths(6)->subDay()->endOfDay()],
            'allTime' => $allTimeStart ? [$allTimeStart->copy()->startOfDay(), $now->copy()->endOfDay()] : null,
            'custom' => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
            default => null,
        };
    }

    function stencil_date_preset_metadata(string $keys, ?Carbon $allTimeStart = null): array
    {
        $items = [];

        foreach (preg_split('/\s+/', trim($keys)) ?: [] as $key) {
            if ($key === '' || $key === 'custom') {
                continue;
            }

            if ($key === 'allTime' && $allTimeStart === null) {
                continue;
            }

            $dates = stencil_date_preset_dates($key, $allTimeStart);

            if ($dates === null) {
                continue;
            }

            [$start, $end] = $dates;

            $items[] = [
                'key' => $key,
                'label' => stencil_date_preset_label($key),
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
            ];
        }

        return $items;
    }

    function stencil_field_has_errors(?string $name): bool
    {
        if (! filled($name)) {
            return false;
        }

        $errors = View::shared('errors');

        return $errors instanceof ViewErrorBag && $errors->has($name);
    }
}

if (! function_exists('stencil_ancestor_attribute')) {
    /**
     * Read a raw value shared by an ancestor component, mirroring the
     * lookup Blade performs for @aware, without requiring the directive.
     */
    function stencil_ancestor_attribute(string $key, mixed $default = null): mixed
    {
        $factory = View::getFacadeRoot();

        if (! method_exists($factory, 'getConsumableComponentData')) {
            return $default;
        }

        return $factory->getConsumableComponentData($key, $default);
    }
}
