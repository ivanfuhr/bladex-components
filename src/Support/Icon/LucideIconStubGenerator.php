<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Support\Icon;

use InvalidArgumentException;
use RuntimeException;

final class LucideIconStubGenerator
{
    public function generate(string $iconName, string $svgContents): string
    {
        $name = IconPathResolver::normalizeName($iconName);
        $inner = $this->extractSvgInner($svgContents);

        $escapedName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        return <<<BLADE
{{-- Icon: {$escapedName} (Lucide, ISC) https://lucide.dev/icons/{$escapedName} --}}
@props([
    'variant' => 'outline',
])

<x-stencil::icon.lucide :variant="\$variant" {{ \$attributes }}>
{$inner}
</x-stencil::icon.lucide>
BLADE;
    }

    private function extractSvgInner(string $svgContents): string
    {
        if (! preg_match('/<svg\b[^>]*>(.*)<\/svg>/is', $svgContents, $matches)) {
            throw new InvalidArgumentException('Lucide SVG is missing a root <svg> element.');
        }

        // Root <svg> (with its width/height) is discarded; keep inner geometry intact —
        // Lucide <rect> elements need width/height to render.
        $inner = trim($matches[1]);

        if ($inner === '') {
            throw new RuntimeException('Lucide SVG has no drawable content.');
        }

        return $this->indent($inner, 4);
    }

    private function indent(string $content, int $spaces): string
    {
        $padding = str_repeat(' ', $spaces);
        $lines = preg_split('/\R/', $content) ?: [];

        return collect($lines)
            ->map(static fn (string $line): string => $line === '' ? '' : $padding.$line)
            ->implode("\n");
    }
}
