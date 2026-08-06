<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\Support\Date;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use Exception;

class DateRange extends CarbonPeriod
{
    protected ?DateRangePreset $preset = null;

    public function start(): ?Carbon
    {
        $date = $this->getStartDate();

        return $date instanceof Carbon ? $date : null;
    }

    public function end(): ?Carbon
    {
        $date = $this->getEndDate();

        return $date instanceof Carbon ? $date : null;
    }

    public function preset(): ?DateRangePreset
    {
        return $this->preset;
    }

    public function hasStart(): bool
    {
        return $this->start() !== null;
    }

    public function hasEnd(): bool
    {
        return $this->end() !== null;
    }

    public function hasPreset(): bool
    {
        return $this->preset !== null;
    }

    public function isNotAllTime(): bool
    {
        return $this->preset !== DateRangePreset::AllTime;
    }

    protected static function fromPreset(DateRangePreset $preset): self
    {
        if ($preset === DateRangePreset::AllTime) {
            throw new Exception('All time date range requires a start date. Use DateRange::allTime($start).');
        }

        $instance = new self(...$preset->dates());
        $instance->preset = $preset;

        return $instance;
    }

    public static function today(): self
    {
        return self::fromPreset(DateRangePreset::Today);
    }

    public static function yesterday(): self
    {
        return self::fromPreset(DateRangePreset::Yesterday);
    }

    public static function thisWeek(): self
    {
        return self::fromPreset(DateRangePreset::ThisWeek);
    }

    public static function lastWeek(): self
    {
        return self::fromPreset(DateRangePreset::LastWeek);
    }

    public static function last7Days(): self
    {
        return self::fromPreset(DateRangePreset::Last7Days);
    }

    public static function thisMonth(): self
    {
        return self::fromPreset(DateRangePreset::ThisMonth);
    }

    public static function lastMonth(): self
    {
        return self::fromPreset(DateRangePreset::LastMonth);
    }

    public static function yearToDate(): self
    {
        return self::fromPreset(DateRangePreset::YearToDate);
    }

    public static function allTime(CarbonInterface|string $start): self
    {
        $instance = new self(Carbon::parse($start), Carbon::now());
        $instance->preset = DateRangePreset::AllTime;

        return $instance;
    }

    /**
     * @return array{start: ?string, end: ?string, preset: ?string}
     */
    public function toPickerArray(): array
    {
        return [
            'start' => $this->start()?->format('Y-m-d'),
            'end' => $this->end()?->format('Y-m-d'),
            'preset' => $this->preset?->value,
        ];
    }
}
