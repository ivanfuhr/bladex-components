<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Alert extends StencilComponent
{
    public function __construct(
        public mixed $variant = 'default',
        public mixed $title = null,
        public mixed $icon = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.alert.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        $liveRole = in_array($this->variant, ['danger', 'destructive', 'error', 'warning'], true) ? 'alert' : 'status';
        $liveMode = $liveRole === 'alert' ? 'assertive' : 'polite';

        return [
            'liveRole' => $liveRole,
            'liveMode' => $liveMode,
            'variantClasses' => match ($this->variant) {
                'success' => 'border-green-200 bg-green-50 text-green-950 dark:border-green-900 dark:bg-green-950/40 dark:text-green-50',
                'warning' => 'border-amber-200 bg-amber-50 text-amber-950 dark:border-amber-900 dark:bg-amber-950/40 dark:text-amber-50',
                'danger', 'destructive', 'error' => 'border-red-200 bg-red-50 text-red-950 dark:border-red-900 dark:bg-red-950/40 dark:text-red-50',
                'info' => 'border-sky-200 bg-sky-50 text-sky-950 dark:border-sky-900 dark:bg-sky-950/40 dark:text-sky-50',
                default => 'border-zinc-200 bg-zinc-50 text-zinc-950 dark:border-zinc-800 dark:bg-zinc-900/60 dark:text-zinc-50',
            },
        ];
    }
}
