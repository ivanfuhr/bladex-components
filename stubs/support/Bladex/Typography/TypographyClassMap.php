<?php

declare(strict_types=1);

namespace App\Support\Bladex\Typography;

final class TypographyClassMap
{
    public function __construct(
        private readonly TypographyConfig $typographyConfig,
        private readonly TypographyScale $typographyScale,
    ) {}

    public function fontRole(string $role): string
    {
        $key = $this->typographyConfig->fontFamilyKeyForRole($role);

        return "font-[family-name:var(--font-{$key})]";
    }

    public function headingSizeForLevel(int $level): string
    {
        $normalized = max(1, min(6, $level));
        $anchorLevel = $this->typographyConfig->defaultHeadingLevel();
        $anchorSize = $this->typographyScale->stepUp($this->typographyConfig->defaultTextSize());
        $offset = $anchorLevel - $normalized;
        $size = $anchorSize;

        if ($offset > 0) {
            for ($i = 0; $i < $offset; $i++) {
                $size = $this->typographyScale->stepUp($size);
            }
        } elseif ($offset < 0) {
            for ($i = 0; $i < abs($offset); $i++) {
                $size = $this->typographyScale->stepDown($size);
            }
        }

        return $size;
    }

    public function headingClasses(int $level, ?string $variant = null): string
    {
        $size = $this->headingSizeForLevel($level);

        return collect([
            'heading',
            $this->typographyScale->classes($size),
            $this->fontRole('heading'),
            $this->variantClasses($variant, forHeading: true),
            'font-semibold tracking-tight text-zinc-950 dark:text-zinc-50',
        ])->filter()->implode(' ');
    }

    public function textClasses(?string $size, ?string $variant, ?string $color): string
    {
        return collect([
            'text',
            $this->typographyScale->classes($size),
            $this->fontRole('body'),
            $this->variantClasses($variant, forHeading: false),
            $color !== null && $color !== '' && $color !== 'default'
                ? $this->colorClasses($color)
                : null,
        ])->filter()->implode(' ');
    }

    public function inputControlClasses(?string $inputSize): string
    {
        $scaleSize = $inputSize === 'sm' ? 'sm' : 'default';
        $fileText = $this->typographyScale->textUtility('sm');

        return collect([
            $this->typographyScale->classes($scaleSize),
            $this->fontRole('body'),
            'text-zinc-950 dark:text-zinc-50',
            "file:border-0 file:bg-transparent file:{$fileText} file:font-medium file:text-zinc-950 dark:file:text-zinc-50",
        ])->implode(' ');
    }

    public function buttonLabelClasses(?string $buttonSize): string
    {
        $scaleSize = match ($buttonSize) {
            'xs', 'sm' => 'sm',
            'lg' => 'lg',
            default => 'sm',
        };

        return collect([
            $buttonSize === 'xs' ? 'text-xs leading-4' : $this->typographyScale->classes($scaleSize),
            $this->fontRole('body'),
            'font-medium',
        ])->implode(' ');
    }

    private function variantClasses(?string $variant, bool $forHeading): string
    {
        return match ($variant) {
            'strong' => 'font-semibold text-zinc-950 dark:text-zinc-50',
            'subtle' => 'text-zinc-500 dark:text-zinc-400',
            'error' => 'text-red-600 dark:text-red-400',
            default => $forHeading ? '' : 'text-zinc-700 dark:text-zinc-300',
        };
    }

    private function colorClasses(string $color): string
    {
        $palette = [
            'red', 'orange', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan',
            'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose',
        ];

        if (! in_array($color, $palette, true)) {
            return '';
        }

        return "text-{$color}-600 dark:text-{$color}-400";
    }
}
