<?php

declare(strict_types=1);

namespace App\Support\Bladex\Typography;

use InvalidArgumentException;

final class TypographyScale
{
    public function __construct(
        private readonly TypographyConfig $typographyConfig,
    ) {}

    public function classes(?string $size = null): string
    {
        $key = $this->normalizeSize($size);
        $entry = $this->typographyConfig->scale()[$key];

        return trim("{$entry['text']} {$entry['leading']}");
    }

    public function textUtility(?string $size = null): string
    {
        $key = $this->normalizeSize($size);

        return $this->typographyConfig->scale()[$key]['text'];
    }

    public function normalizeSize(?string $size): string
    {
        if ($size === null || $size === '') {
            return $this->typographyConfig->defaultTextSize();
        }

        if (! in_array($size, TypographyConfig::SCALE_KEYS, true)) {
            throw new InvalidArgumentException("Invalid typography size [{$size}].");
        }

        return $size;
    }

    public function stepUp(string $size): string
    {
        $order = TypographyConfig::SCALE_KEYS;
        $current = $this->normalizeSize($size);
        $index = array_search($current, $order, true);

        if ($index === false) {
            return 'default';
        }

        return $order[min(count($order) - 1, $index + 1)];
    }

    public function stepDown(string $size): string
    {
        $order = TypographyConfig::SCALE_KEYS;
        $current = $this->normalizeSize($size);
        $index = array_search($current, $order, true);

        if ($index === false) {
            return 'default';
        }

        return $order[max(0, $index - 1)];
    }
}
