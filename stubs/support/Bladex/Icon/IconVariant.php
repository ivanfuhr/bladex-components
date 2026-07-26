<?php

declare(strict_types=1);

namespace App\Support\Bladex\Icon;

final class IconVariant
{
    /**
     * @return array{0: string, 1: string, 2: int}
     */
    public static function resolve(string $variant): array
    {
        $normalized = self::normalize($variant);

        return match ($normalized) {
            'mini' => ['size-5', '2.25', 20],
            'micro' => ['size-3', '2.5', 12],
            default => ['size-4', '2', 16],
        };
    }

    public static function normalize(string $variant): string
    {
        if ($variant === 'solid') {
            return 'outline';
        }

        if (in_array($variant, ['outline', 'mini', 'micro'], true)) {
            return $variant;
        }

        return 'outline';
    }

    public static function classString(string $variant): string
    {
        [$sizeClass] = self::resolve($variant);

        return "block shrink-0 {$sizeClass}";
    }

    public static function strokeWidth(string $variant): string
    {
        [, $strokeWidth] = self::resolve($variant);

        return $strokeWidth;
    }

    public static function pixelSize(string $variant): int
    {
        [, , $pixelSize] = self::resolve($variant);

        return $pixelSize;
    }
}
