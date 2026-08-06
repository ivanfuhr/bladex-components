<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\Support\Button;

use Ivanfuhr\StdComponents\Support\Interaction\InteractionStateClassMap;
use Ivanfuhr\StdComponents\Support\Typography\TypographyClassMap;

final class ButtonClassMap
{
    /** @var list<string> */
    private const array PALETTE = [
        'zinc', 'red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan',
        'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose',
    ];

    public function __construct(
        private readonly TypographyClassMap $typography,
        private readonly InteractionStateClassMap $interactionState,
    ) {}

    /**
     * @param  array{
     *     hasLeading?: bool,
     *     hasTrailing?: bool,
     *     square?: bool,
     *     iconOnly?: bool,
     * }  $options
     */
    public function classes(
        ?string $variant = null,
        ?string $size = null,
        ?string $color = null,
        array $options = [],
    ): string {
        $variant = $this->normalizeVariant($variant);
        $size = $this->normalizeSize($size);
        $hasLeading = (bool) ($options['hasLeading'] ?? false);
        $hasTrailing = (bool) ($options['hasTrailing'] ?? false);
        $square = (bool) ($options['square'] ?? false);
        $iconOnly = (bool) ($options['iconOnly'] ?? false);

        return collect([
            'button',
            'inline-flex shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-md',
            $variant !== 'link' ? $this->typography->buttonLabelClasses($size) : $this->typography->buttonLabelClasses($size).' underline-offset-4',
            'transition-colors',
            $variant !== 'link' ? 'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-zinc-300/20 dark:focus-visible:ring-offset-zinc-950' : 'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus-visible:ring-zinc-300/20',
            $this->interactionState->classes(),
            'cursor-pointer aria-disabled:pointer-events-none aria-disabled:cursor-not-allowed',
            '[&_svg]:pointer-events-none [&_svg]:shrink-0',
            $variant !== 'link' ? $this->sizeClasses($size, $square, $iconOnly, $hasLeading, $hasTrailing) : null,
            $this->variantClasses($variant, $color),
        ])->filter()->implode(' ');
    }

    public function normalizeVariant(?string $variant): string
    {
        $variant = $variant ?? 'outline';

        return match ($variant) {
            'destructive' => 'danger',
            'default' => 'primary',
            default => $variant,
        };
    }

    public function normalizeSize(?string $size): string
    {
        $size = $size ?? 'default';

        return match ($size) {
            'base' => 'default',
            default => $size,
        };
    }

    private function sizeClasses(
        string $size,
        bool $square,
        bool $iconOnly,
        bool $hasLeading,
        bool $hasTrailing,
    ): string {
        $iconOnly = $iconOnly || ($square && ! $hasLeading && ! $hasTrailing);

        if ($iconOnly || $square) {
            return match ($size) {
                'xs' => 'size-8 [&_[data-icon]]:size-3.5',
                'sm' => 'size-10 [&_[data-icon]]:size-3.5',
                'lg' => 'size-12 [&_[data-icon]]:size-5',
                default => 'size-11 [&_[data-icon]]:size-4',
            };
        }

        $height = match ($size) {
            'xs' => 'h-8 px-2.5',
            'sm' => 'h-10 px-3',
            'lg' => 'h-12 px-6',
            default => 'h-11 px-4',
        };

        $iconSize = match ($size) {
            'xs' => '[&_[data-icon]]:size-3.5',
            'lg' => '[&_[data-icon]]:size-5',
            default => '[&_[data-icon]]:size-4',
        };

        return collect([$height, $iconSize])->implode(' ');
    }

    private function variantClasses(string $variant, ?string $color): string
    {
        return match ($variant) {
            'primary' => $this->primaryClasses($color),
            'filled' => $this->primaryClasses($color),
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

    private function primaryClasses(?string $color): string
    {
        $color = $color !== null && $color !== '' ? strtolower($color) : 'zinc';

        if ($color === 'zinc' || ! in_array($color, self::PALETTE, true)) {
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
}
