<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Badge extends StencilComponent
{
    public function __construct(
        public mixed $variant = 'secondary',
        public mixed $color = null,
        public mixed $size = null,
        public bool $rounded = false,
        public mixed $href = null,
        public mixed $as = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.badge.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        $sizeClasses = match ($this->size) {
            'sm' => 'px-1.5 py-0 text-[10px]',
            'lg' => 'px-2.5 py-1 text-sm',
            default => 'px-2 py-0.5 text-xs',
        };

        $baseClasses = [
            'badge',
            'inline-flex items-center gap-1 font-medium whitespace-nowrap',
            $this->rounded ? 'rounded-full' : 'rounded-md',
            $sizeClasses,
        ];

        $variantClasses = match (true) {
            filled($this->color) && $this->variant === 'solid' => match ($this->color) {
                'red' => 'bg-red-600 text-white',
                'orange' => 'bg-orange-600 text-white',
                'amber' => 'bg-amber-500 text-zinc-950',
                'green' => 'bg-green-600 text-white',
                'blue' => 'bg-blue-600 text-white',
                'indigo' => 'bg-indigo-600 text-white',
                'violet' => 'bg-violet-600 text-white',
                'rose' => 'bg-rose-600 text-white',
                'lime' => 'bg-lime-500 text-zinc-950',
                default => 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900',
            },
            filled($this->color) => match ($this->color) {
                'red' => 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300',
                'orange' => 'bg-orange-100 text-orange-700 dark:bg-orange-950 dark:text-orange-300',
                'amber' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
                'green' => 'bg-green-100 text-green-700 dark:bg-green-950 dark:text-green-300',
                'blue' => 'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300',
                'indigo' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300',
                'violet' => 'bg-violet-100 text-violet-700 dark:bg-violet-950 dark:text-violet-300',
                'rose' => 'bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300',
                'lime' => 'bg-lime-100 text-lime-800 dark:bg-lime-950 dark:text-lime-300',
                default => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200',
            },
            $this->variant === 'default' || $this->variant === 'primary' => 'bg-zinc-900 text-zinc-50 dark:bg-zinc-50 dark:text-zinc-900',
            $this->variant === 'destructive' || $this->variant === 'danger' => 'bg-red-600 text-white',
            $this->variant === 'outline' => 'border border-zinc-200 bg-transparent text-zinc-700 dark:border-zinc-700 dark:text-zinc-200',
            $this->variant === 'ghost' => 'bg-transparent text-zinc-600 dark:text-zinc-300',
            $this->variant === 'solid' => 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900',
            default => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200',
        };

        $useLink = filled($this->href);

        return [
            'baseClasses' => $baseClasses,
            'variantClasses' => $variantClasses,
            'useLink' => $useLink,
            'tag' => $useLink ? 'a' : ($this->as === 'button' ? 'button' : 'span'),
        ];
    }
}
