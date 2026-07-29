<?php

declare(strict_types=1);

use Carbon\Carbon;
use Ivanfuhr\Stencil\Support\Chrono\ChronoFormatter;
use Ivanfuhr\Stencil\Support\Chrono\DateRange;
use Ivanfuhr\Stencil\Support\Chrono\DateRangePreset;

it('builds last month preset range', function () {
    Carbon::setTestNow(Carbon::parse('2026-03-15'));

    $range = DateRange::lastMonth();

    expect($range->start()?->format('Y-m-d'))->toBe('2026-02-01')
        ->and($range->end()?->format('Y-m-d'))->toBe('2026-02-28')
        ->and($range->preset())->toBe(DateRangePreset::LastMonth);
});

it('builds all time range with custom start', function () {
    Carbon::setTestNow(Carbon::parse('2026-07-15'));

    $range = DateRange::allTime('2020-01-01');

    expect($range->preset())->toBe(DateRangePreset::AllTime)
        ->and($range->start()?->format('Y-m-d'))->toBe('2020-01-01');
});

it('normalizes array range values for pickers', function () {
    expect(ChronoFormatter::normalizeDateValue([
        'start' => '2026-01-01',
        'end' => '2026-01-31',
    ], 'range'))->toBe('2026-01-01/2026-01-31');
});

it('exports preset metadata for javascript', function () {
    Carbon::setTestNow(Carbon::parse('2026-07-15'));

    $meta = DateRangePreset::metadataForKeys('today last7Days');

    expect($meta)->toHaveCount(2)
        ->and($meta[0]['key'])->toBe('today')
        ->and($meta[0]['start'])->toBe('2026-07-15');
});
