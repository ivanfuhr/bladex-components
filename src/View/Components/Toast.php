<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Toast extends StencilComponent
{
    public function __construct(
        public mixed $variant = 'default',
        public mixed $title = null,
        public mixed $description = null,
        public mixed $icon = null,
        public bool $showIcon = true,
        public int $duration = 4000,
        public bool $open = true,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.toast.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $variantClasses = match ($this->variant) {
            'success' => 'border-green-200 bg-green-50 text-green-950 dark:border-green-900 dark:bg-green-950 dark:text-green-50',
            'danger', 'destructive', 'error' => 'border-red-200 bg-red-50 text-red-950 dark:border-red-900 dark:bg-red-950 dark:text-red-50',
            'warning' => 'border-amber-200 bg-amber-50 text-amber-950 dark:border-amber-900 dark:bg-amber-950 dark:text-amber-50',
            default => 'border-zinc-200 bg-white text-zinc-950 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
        };

        $liveRole = in_array($this->variant, ['danger', 'destructive', 'error'], true) ? 'alert' : 'status';
        $liveMode = $liveRole === 'alert' ? 'assertive' : 'polite';

        return [
            'variantClasses' => $variantClasses,
            'liveRole' => $liveRole,
            'liveMode' => $liveMode,
            'resolvedIcon' => $this->resolveIcon(),
        ];
    }

    private function resolveIcon(): ?string
    {
        if (! $this->showIcon) {
            return null;
        }

        if (filled($this->icon)) {
            return (string) $this->icon;
        }

        return match ($this->variant) {
            'success' => 'check',
            'warning' => 'clipboard',
            'danger', 'destructive', 'error' => 'x',
            default => null,
        };
    }
}
