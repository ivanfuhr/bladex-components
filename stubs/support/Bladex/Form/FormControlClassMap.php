<?php

declare(strict_types=1);

namespace App\Support\Bladex\Form;

use App\Support\Bladex\Interaction\InteractionStateClassMap;
use App\Support\Bladex\Typography\TypographyClassMap;

final class FormControlClassMap
{
    public function __construct(
        private readonly TypographyClassMap $typography,
        private readonly InteractionStateClassMap $interactionState,
    ) {}

    public function fieldSurfaceClasses(?string $size, bool $includeReadOnly = true): string
    {
        return collect([
            'rounded-md border border-zinc-200 bg-white px-3 py-1 shadow-sm transition-colors',
            $this->typography->inputControlClasses($size),
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-0',
            $this->interactionState->classes(includeReadOnly: $includeReadOnly),
            'dark:border-zinc-800 dark:bg-zinc-950',
            'dark:focus-visible:ring-zinc-300/20',
            $size === 'sm' ? 'h-8 px-2.5' : 'h-9',
        ])->implode(' ');
    }

    public function invalidFieldClasses(): string
    {
        return implode(' ', [
            'aria-invalid:border-red-500 aria-invalid:text-red-950 aria-invalid:placeholder:text-red-400',
            'aria-invalid:focus-visible:ring-red-500/20',
            'dark:aria-invalid:border-red-500 dark:aria-invalid:text-red-50',
        ]);
    }

    public function selectListboxClasses(?string $size): string
    {
        return collect([
            'z-[200] max-h-60 min-w-[8rem] overflow-y-auto overflow-x-hidden rounded-md border border-zinc-200 bg-white p-1 shadow-md',
            $this->typography->inputControlClasses($size),
            'text-zinc-950 focus:outline-none',
            'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
        ])->implode(' ');
    }

    public function selectOptionClasses(?string $size): string
    {
        return collect([
            'relative flex w-full cursor-default select-none items-center gap-2 rounded-sm py-1.5 pl-2 pr-8 outline-none',
            $this->typography->textClasses($size === 'sm' ? 'sm' : null, null, null),
            'text-zinc-950 dark:text-zinc-50',
            'hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
            'data-[highlighted]:bg-zinc-100 data-[highlighted]:text-zinc-900',
            'dark:data-[highlighted]:bg-zinc-800 dark:data-[highlighted]:text-zinc-50',
            'data-[disabled]:pointer-events-none data-[disabled]:opacity-50',
            $size === 'sm' ? 'py-1' : null,
        ])->filter()->implode(' ');
    }
}
