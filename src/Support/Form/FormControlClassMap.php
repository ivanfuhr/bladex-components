<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Support\Form;

use Ivanfuhr\Stencil\Support\Interaction\InteractionStateClassMap;
use Ivanfuhr\Stencil\Support\Typography\TypographyClassMap;

final class FormControlClassMap
{
    public function __construct(
        private readonly TypographyClassMap $typography,
        private readonly InteractionStateClassMap $interactionState,
    ) {}

    public function fieldSurfaceClasses(?string $size, bool $includeReadOnly = true, string $cursor = 'text'): string
    {
        $cursorClasses = match ($cursor) {
            'pointer' => $this->interactionState->cursorPointerClasses(),
            'default' => $this->interactionState->cursorDefaultClasses(),
            default => $this->interactionState->cursorTextClasses(),
        };

        return collect([
            'rounded-md border border-zinc-200 bg-white px-3 py-1 shadow-sm transition-colors',
            $cursorClasses,
            $this->typography->inputControlClasses($size),
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-0',
            $this->interactionState->classes(includeReadOnly: $includeReadOnly),
            'dark:border-zinc-800 dark:bg-zinc-950',
            'dark:focus-visible:ring-zinc-300/20',
            $size === 'sm' ? 'h-8 px-2.5' : 'h-9',
        ])->implode(' ');
    }

    public function textareaSurfaceClasses(?string $size, bool $includeReadOnly = true): string
    {
        $cursorClasses = $this->interactionState->cursorTextClasses();

        return collect([
            'rounded-md border border-zinc-200 bg-white px-3 py-2 shadow-sm transition-colors',
            $cursorClasses,
            $this->typography->inputControlClasses($size),
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-0',
            $this->interactionState->classes(includeReadOnly: $includeReadOnly),
            'dark:border-zinc-800 dark:bg-zinc-950',
            'dark:focus-visible:ring-zinc-300/20',
            'min-h-[5rem] w-full resize-y',
            $size === 'sm' ? 'min-h-[4rem] px-2.5' : null,
        ])->filter()->implode(' ');
    }

    public function labelClasses(): string
    {
        return collect([
            $this->typography->textClasses('sm', 'strong', null),
            'text-zinc-950 dark:text-zinc-50',
        ])->implode(' ');
    }

    /**
     * @param  'checkbox'|'radio'  $type
     */
    public function choiceControlClasses(string $type = 'checkbox', ?string $size = null): string
    {
        $dimension = $size === 'sm' ? 'size-3.5' : 'size-4';
        $rounded = $type === 'radio' ? 'rounded-full' : 'rounded-[4px]';

        return collect([
            'choice-control',
            $dimension,
            'shrink-0',
            $rounded,
            'border border-zinc-300 bg-white shadow-sm transition-colors',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-2 focus-visible:ring-offset-white',
            'disabled:cursor-not-allowed disabled:opacity-50',
            'dark:border-zinc-600 dark:bg-zinc-950 dark:focus-visible:ring-zinc-300/20 dark:focus-visible:ring-offset-zinc-950',
            'checked:border-zinc-900 checked:bg-zinc-900 checked:text-white',
            'dark:checked:border-zinc-50 dark:checked:bg-zinc-50 dark:checked:text-zinc-900',
            'aria-invalid:border-red-500 aria-invalid:ring-red-500/20',
            'dark:aria-invalid:border-red-500',
        ])->implode(' ');
    }

    public function switchTrackClasses(?string $size = null): string
    {
        $track = $size === 'sm' ? 'h-5 w-9' : 'h-6 w-11';

        return collect([
            'switch__track',
            'relative inline-flex shrink-0 items-center rounded-full border-2 border-transparent p-0.5 transition-colors',
            $track,
            'bg-zinc-200 dark:bg-zinc-700',
        ])->implode(' ');
    }

    public function switchThumbClasses(?string $size = null): string
    {
        $thumb = $size === 'sm' ? 'size-4' : 'size-5';

        return collect([
            'switch__thumb',
            'pointer-events-none block rounded-full bg-white shadow-lg ring-0 transition-transform',
            $thumb,
            'dark:bg-zinc-950',
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
            'z-[200] flex max-h-60 min-w-[8rem] flex-col gap-1 overflow-y-auto overflow-x-hidden rounded-md border border-zinc-200 bg-white p-1 shadow-md',
            $this->typography->inputControlClasses($size),
            'text-zinc-950 focus:outline-none',
            'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
        ])->implode(' ');
    }

    public function selectOptionClasses(?string $size): string
    {
        return collect([
            'relative flex w-full select-none items-center gap-2 rounded-sm py-1.5 pl-2 pr-8 outline-none',
            $this->interactionState->cursorPointerClasses(),
            $this->typography->textClasses($size === 'sm' ? 'sm' : null, null, null),
            'text-zinc-950 dark:text-zinc-50',
            'hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
            'data-[highlighted]:bg-zinc-100 data-[highlighted]:text-zinc-900',
            'dark:data-[highlighted]:bg-zinc-800 dark:data-[highlighted]:text-zinc-50',
            'data-[disabled]:pointer-events-none data-[disabled]:cursor-not-allowed data-[disabled]:opacity-50',
            $size === 'sm' ? 'py-1' : null,
        ])->filter()->implode(' ');
    }
}
