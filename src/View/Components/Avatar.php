<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Avatar extends StdComponent
{
    public function __construct(
        public mixed $src = null,
        public mixed $alt = null,
        public mixed $name = null,
        public mixed $initials = null,
        public mixed $size = 'md',
        public bool $circle = false,
        public mixed $color = null,
        public mixed $href = null,
        public mixed $as = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.avatar.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        $sizeClasses = match ($this->size) {
            'xs' => 'size-6 text-[10px]',
            'sm' => 'size-8 text-xs',
            'lg' => 'size-12 text-base',
            'xl' => 'size-16 text-lg',
            default => 'size-10 text-sm',
        };

        if (filled($this->initials)) {
            $resolvedInitials = (string) $this->initials;
        } elseif (filled($this->name)) {
            $parts = preg_split('/\s+/', trim((string) $this->name)) ?: [];
            $resolvedInitials = collect($parts)
                ->filter()
                ->take(2)
                ->map(fn (string $part): string => mb_strtoupper(mb_substr($part, 0, 1)))
                ->implode('');

            if ($resolvedInitials === '') {
                $resolvedInitials = mb_strtoupper(mb_substr((string) $this->name, 0, 2));
            }
        } else {
            $resolvedInitials = null;
        }

        $resolvedAlt = $this->alt ?? $this->name ?? 'Avatar';

        $palette = [
            'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300',
            'bg-orange-100 text-orange-700 dark:bg-orange-950 dark:text-orange-300',
            'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
            'bg-green-100 text-green-700 dark:bg-green-950 dark:text-green-300',
            'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300',
            'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300',
            'bg-violet-100 text-violet-700 dark:bg-violet-950 dark:text-violet-300',
            'bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300',
        ];

        $colorClasses = match ($this->color) {
            'red' => $palette[0],
            'orange' => $palette[1],
            'amber' => $palette[2],
            'green' => $palette[3],
            'blue' => $palette[4],
            'indigo' => $palette[5],
            'violet' => $palette[6],
            'rose' => $palette[7],
            'auto' => $palette[crc32(filled($this->name) ? (string) $this->name : (string) ($resolvedInitials ?? 'A')) % count($palette)],
            default => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200',
        };

        $useLink = filled($this->href) || $this->as === 'a';
        $isInteractive = $useLink || $this->as === 'button';

        return [
            'sizeClasses' => $sizeClasses,
            'resolvedInitials' => $resolvedInitials,
            'resolvedAlt' => $resolvedAlt,
            'colorClasses' => $colorClasses,
            'shapeClass' => $this->circle ? 'rounded-full' : 'rounded-lg',
            'useLink' => $useLink,
            'isInteractive' => $isInteractive,
            'hasImage' => filled($this->src),
            'tag' => $useLink ? 'a' : ($this->as === 'button' ? 'button' : 'span'),
        ];
    }
}
