<?php

declare(strict_types=1);

namespace App\Support\Stencil\Interaction;

final class InteractionStateClassMap
{
    public function cursorTextClasses(): string
    {
        return 'cursor-text';
    }

    public function cursorPointerClasses(): string
    {
        return 'cursor-pointer';
    }

    public function cursorDefaultClasses(): string
    {
        return 'cursor-default';
    }

    public function classes(bool $includeReadOnly = false): string
    {
        return collect([
            'disabled:cursor-not-allowed disabled:opacity-50',
            'aria-disabled:cursor-not-allowed',
            'data-loading:pointer-events-none data-loading:cursor-wait data-loading:opacity-70',
            'aria-busy:pointer-events-none aria-busy:cursor-wait aria-busy:opacity-70',
            $includeReadOnly
                ? 'read-only:cursor-default read-only:bg-zinc-50 read-only:opacity-100 dark:read-only:bg-zinc-900/50'
                : null,
        ])->filter()->implode(' ');
    }
}
