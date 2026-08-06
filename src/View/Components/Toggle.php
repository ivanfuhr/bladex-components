<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Toggle extends StdComponent
{
    public function __construct(
        public bool $pressed = false,
        public string $variant = 'default',
        public mixed $size = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.toggle.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $pressed = $this->pressed;

        if (! $pressed && $this->attributes->has('pressed')) {
            $pressed = filter_var($this->attributes->get('pressed'), FILTER_VALIDATE_BOOLEAN);
        }

        $variant = in_array($this->variant, ['default', 'outline'], true) ? $this->variant : 'default';
        $size = match ($this->size) {
            'sm', 'lg' => $this->size,
            'xs' => 'sm',
            default => 'default',
        };

        $sizeClasses = match ($size) {
            'sm' => 'h-10 min-w-10 px-1.5 text-sm',
            'lg' => 'h-12 min-w-12 px-2.5 text-base',
            default => 'h-11 min-w-11 px-2 text-sm',
        };

        $variantClasses = match ($variant) {
            'outline' => implode(' ', [
                'border border-zinc-200 bg-transparent shadow-sm',
                'hover:bg-zinc-100 hover:text-zinc-900',
                'dark:border-zinc-800 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
            ]),
            default => implode(' ', [
                'bg-transparent',
                'hover:bg-zinc-100 hover:text-zinc-900',
                'dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
            ]),
        };

        $mergedAttributes = std_apply_interaction($this->attributes
            ->class([
                'toggle',
                'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium',
                'transition-colors outline-none',
                'focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus-visible:ring-zinc-300/20',
                'disabled:pointer-events-none disabled:opacity-50',
                'cursor-pointer',
                '[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=size-])]:size-4',
                'data-[state=on]:bg-zinc-100 data-[state=on]:text-zinc-900',
                'dark:data-[state=on]:bg-zinc-800 dark:data-[state=on]:text-zinc-50',
                $sizeClasses,
                $variantClasses,
            ])
            ->merge([
                'type' => 'button',
                'data-toggle' => true,
                'data-variant' => $variant,
                'data-size' => $size,
                'data-state' => $pressed ? 'on' : 'off',
                'aria-pressed' => $pressed ? 'true' : 'false',
            ]),
            nativeDisabled: true,
        );

        return [
            'pressed' => $pressed,
            'variant' => $variant,
            'size' => $size,
            'mergedAttributes' => $mergedAttributes,
        ];
    }
}
