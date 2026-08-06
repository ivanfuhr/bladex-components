<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Stat extends StdComponent
{
    public function __construct(
        public mixed $label = null,
        public mixed $value = null,
        public mixed $description = null,
        public mixed $trend = null,
        public mixed $trendDirection = null,
        public mixed $icon = null,
        public mixed $variant = 'default',
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.stat.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $variant = filled($this->variant) ? $this->variant : 'default';

        $variantClasses = match ($variant) {
            'outline' => 'border border-zinc-200 bg-transparent shadow-none dark:border-zinc-800',
            'muted' => 'border border-transparent bg-zinc-100 shadow-none dark:bg-zinc-900',
            default => 'border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-950',
        };

        return [
            'variant' => $variant,
            'variantClasses' => $variantClasses,
        ];
    }
}
