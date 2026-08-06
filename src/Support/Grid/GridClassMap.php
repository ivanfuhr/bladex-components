<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\Support\Grid;

final class GridClassMap
{
    /** @var list<string> */
    private const array BREAKPOINTS = ['sm', 'md', 'lg', 'xl', '2xl'];

    /** @var list<string> */
    private const array GAP_TOKENS = ['3', '4', '5', '8', '10'];

    public const string SCAN_CLASSES = self::SCAN_GRID_CLASSES.' '.self::SCAN_SPAN_CLASSES;

    private const string SCAN_GRID_CLASSES = <<<'CLASSES'
grid @container
grid-cols-1 grid-cols-2 grid-cols-3 grid-cols-4 grid-cols-5 grid-cols-6 grid-cols-7 grid-cols-8 grid-cols-9 grid-cols-10 grid-cols-11 grid-cols-12
sm:grid-cols-1 sm:grid-cols-2 sm:grid-cols-3 sm:grid-cols-4 sm:grid-cols-5 sm:grid-cols-6 sm:grid-cols-7 sm:grid-cols-8 sm:grid-cols-9 sm:grid-cols-10 sm:grid-cols-11 sm:grid-cols-12
md:grid-cols-1 md:grid-cols-2 md:grid-cols-3 md:grid-cols-4 md:grid-cols-5 md:grid-cols-6 md:grid-cols-7 md:grid-cols-8 md:grid-cols-9 md:grid-cols-10 md:grid-cols-11 md:grid-cols-12
lg:grid-cols-1 lg:grid-cols-2 lg:grid-cols-3 lg:grid-cols-4 lg:grid-cols-5 lg:grid-cols-6 lg:grid-cols-7 lg:grid-cols-8 lg:grid-cols-9 lg:grid-cols-10 lg:grid-cols-11 lg:grid-cols-12
xl:grid-cols-1 xl:grid-cols-2 xl:grid-cols-3 xl:grid-cols-4 xl:grid-cols-5 xl:grid-cols-6 xl:grid-cols-7 xl:grid-cols-8 xl:grid-cols-9 xl:grid-cols-10 xl:grid-cols-11 xl:grid-cols-12
2xl:grid-cols-1 2xl:grid-cols-2 2xl:grid-cols-3 2xl:grid-cols-4 2xl:grid-cols-5 2xl:grid-cols-6 2xl:grid-cols-7 2xl:grid-cols-8 2xl:grid-cols-9 2xl:grid-cols-10 2xl:grid-cols-11 2xl:grid-cols-12
@sm:grid-cols-1 @sm:grid-cols-2 @sm:grid-cols-3 @sm:grid-cols-4 @sm:grid-cols-5 @sm:grid-cols-6 @sm:grid-cols-7 @sm:grid-cols-8 @sm:grid-cols-9 @sm:grid-cols-10 @sm:grid-cols-11 @sm:grid-cols-12
@md:grid-cols-1 @md:grid-cols-2 @md:grid-cols-3 @md:grid-cols-4 @md:grid-cols-5 @md:grid-cols-6 @md:grid-cols-7 @md:grid-cols-8 @md:grid-cols-9 @md:grid-cols-10 @md:grid-cols-11 @md:grid-cols-12
@lg:grid-cols-1 @lg:grid-cols-2 @lg:grid-cols-3 @lg:grid-cols-4 @lg:grid-cols-5 @lg:grid-cols-6 @lg:grid-cols-7 @lg:grid-cols-8 @lg:grid-cols-9 @lg:grid-cols-10 @lg:grid-cols-11 @lg:grid-cols-12
@xl:grid-cols-1 @xl:grid-cols-2 @xl:grid-cols-3 @xl:grid-cols-4 @xl:grid-cols-5 @xl:grid-cols-6 @xl:grid-cols-7 @xl:grid-cols-8 @xl:grid-cols-9 @xl:grid-cols-10 @xl:grid-cols-11 @xl:grid-cols-12
@2xl:grid-cols-1 @2xl:grid-cols-2 @2xl:grid-cols-3 @2xl:grid-cols-4 @2xl:grid-cols-5 @2xl:grid-cols-6 @2xl:grid-cols-7 @2xl:grid-cols-8 @2xl:grid-cols-9 @2xl:grid-cols-10 @2xl:grid-cols-11 @2xl:grid-cols-12
gap-3 gap-4 gap-5 gap-8 gap-10
CLASSES;

    private const string SCAN_SPAN_CLASSES = <<<'CLASSES'
col-span-1 col-span-2 col-span-3 col-span-4 col-span-5 col-span-6 col-span-7 col-span-8 col-span-9 col-span-10 col-span-11 col-span-12 col-span-full
sm:col-span-1 sm:col-span-2 sm:col-span-3 sm:col-span-4 sm:col-span-5 sm:col-span-6 sm:col-span-7 sm:col-span-8 sm:col-span-9 sm:col-span-10 sm:col-span-11 sm:col-span-12 sm:col-span-full
md:col-span-1 md:col-span-2 md:col-span-3 md:col-span-4 md:col-span-5 md:col-span-6 md:col-span-7 md:col-span-8 md:col-span-9 md:col-span-10 md:col-span-11 md:col-span-12 md:col-span-full
lg:col-span-1 lg:col-span-2 lg:col-span-3 lg:col-span-4 lg:col-span-5 lg:col-span-6 lg:col-span-7 lg:col-span-8 lg:col-span-9 lg:col-span-10 lg:col-span-11 lg:col-span-12 lg:col-span-full
xl:col-span-1 xl:col-span-2 xl:col-span-3 xl:col-span-4 xl:col-span-5 xl:col-span-6 xl:col-span-7 xl:col-span-8 xl:col-span-9 xl:col-span-10 xl:col-span-11 xl:col-span-12 xl:col-span-full
2xl:col-span-1 2xl:col-span-2 2xl:col-span-3 2xl:col-span-4 2xl:col-span-5 2xl:col-span-6 2xl:col-span-7 2xl:col-span-8 2xl:col-span-9 2xl:col-span-10 2xl:col-span-11 2xl:col-span-12 2xl:col-span-full
@sm:col-span-1 @sm:col-span-2 @sm:col-span-3 @sm:col-span-4 @sm:col-span-5 @sm:col-span-6 @sm:col-span-7 @sm:col-span-8 @sm:col-span-9 @sm:col-span-10 @sm:col-span-11 @sm:col-span-12 @sm:col-span-full
@md:col-span-1 @md:col-span-2 @md:col-span-3 @md:col-span-4 @md:col-span-5 @md:col-span-6 @md:col-span-7 @md:col-span-8 @md:col-span-9 @md:col-span-10 @md:col-span-11 @md:col-span-12 @md:col-span-full
@lg:col-span-1 @lg:col-span-2 @lg:col-span-3 @lg:col-span-4 @lg:col-span-5 @lg:col-span-6 @lg:col-span-7 @lg:col-span-8 @lg:col-span-9 @lg:col-span-10 @lg:col-span-11 @lg:col-span-12 @lg:col-span-full
@xl:col-span-1 @xl:col-span-2 @xl:col-span-3 @xl:col-span-4 @xl:col-span-5 @xl:col-span-6 @xl:col-span-7 @xl:col-span-8 @xl:col-span-9 @xl:col-span-10 @xl:col-span-11 @xl:col-span-12 @xl:col-span-full
@2xl:col-span-1 @2xl:col-span-2 @2xl:col-span-3 @2xl:col-span-4 @2xl:col-span-5 @2xl:col-span-6 @2xl:col-span-7 @2xl:col-span-8 @2xl:col-span-9 @2xl:col-span-10 @2xl:col-span-11 @2xl:col-span-12 @2xl:col-span-full
CLASSES;

    /**
     * @param  array<string, int|null>  $breakpointColumns
     */
    public function gridClasses(
        int $cols = 1,
        array $breakpointColumns = [],
        string $gap = '4',
        bool $container = true,
    ): string {
        $classes = ['grid'];

        $classes[] = $this->columnClass($cols, null, $container);

        foreach (self::BREAKPOINTS as $breakpoint) {
            $count = $breakpointColumns[$breakpoint] ?? null;

            if ($count !== null) {
                $classes[] = $this->columnClass($count, $breakpoint, $container);
            }
        }

        $classes[] = $this->gapClass($gap);

        return collect($classes)->filter()->implode(' ');
    }

    public function containerWrapperClasses(): string
    {
        return '@container';
    }

    /**
     * @param  array<string, int|string|null>  $breakpointSpans
     */
    public function itemClasses(
        int|string|null $span = 1,
        array $breakpointSpans = [],
        bool $container = true,
    ): string {
        $classes = [];

        if ($this->shouldEmitSpan($span)) {
            $classes[] = $this->spanClass($span, null, $container);
        }

        foreach (self::BREAKPOINTS as $breakpoint) {
            $value = $breakpointSpans[$breakpoint] ?? null;

            if ($this->shouldEmitSpan($value)) {
                $classes[] = $this->spanClass($value, $breakpoint, $container);
            }
        }

        return collect($classes)->filter()->implode(' ');
    }

    public function normalizeColumnCount(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (! is_numeric($value)) {
            return null;
        }

        return max(1, min(12, (int) $value));
    }

    public function normalizeSpan(mixed $value): int|string|null
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value === 'full') {
            return 'full';
        }

        if (! is_numeric($value)) {
            return null;
        }

        return max(1, min(12, (int) $value));
    }

    public function normalizeGap(mixed $gap): string
    {
        $gap = (string) ($gap ?? '4');

        return in_array($gap, self::GAP_TOKENS, true) ? $gap : '4';
    }

    private function columnClass(int $count, ?string $breakpoint, bool $container): string
    {
        $count = max(1, min(12, $count));
        $utility = "grid-cols-{$count}";

        if ($breakpoint === null) {
            return $utility;
        }

        $prefix = $container ? "@{$breakpoint}" : $breakpoint;

        return "{$prefix}:{$utility}";
    }

    private function spanClass(int|string $span, ?string $breakpoint, bool $container): string
    {
        $utility = $span === 'full'
          ? 'col-span-full'
          : 'col-span-'.max(1, min(12, (int) $span));

        if ($breakpoint === null) {
            return $utility;
        }

        $prefix = $container ? "@{$breakpoint}" : $breakpoint;

        return "{$prefix}:{$utility}";
    }

    private function gapClass(string $gap): string
    {
        return 'gap-'.$this->normalizeGap($gap);
    }

    private function shouldEmitSpan(int|string|null $span): bool
    {
        if ($span === null || $span === '' || $span === 1 || $span === '1') {
            return false;
        }

        return true;
    }
}
