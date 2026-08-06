<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\ColorPicker;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Trigger extends StdComponent
{
    public function __construct(
        public mixed $currentValue = '#000000',
        public mixed $popoverId = null,
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $size = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.color-picker.trigger';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $isSmall = $this->size === 'sm';
        $swatchWidth = $isSmall ? 'w-9' : 'w-10';

        $triggerClasses = collect([
            'color-picker__trigger',
            'relative flex min-w-0 overflow-hidden rounded-md border border-zinc-200 bg-white shadow-sm transition-colors',
            'focus-within:outline-none focus-within:ring-2 focus-within:ring-zinc-950/10 focus-within:ring-offset-0',
            'dark:border-zinc-800 dark:bg-zinc-950 dark:focus-within:ring-zinc-300/20',
            std_invalid_field_classes(),
            $this->invalid ? 'border-red-500 focus-within:ring-red-500/20 dark:border-red-500' : null,
            $isSmall ? 'h-8' : 'h-9',
            $this->disabled ? 'opacity-50' : null,
        ])->filter()->implode(' ');

        $swatchButtonClasses = collect([
            'color-picker__swatch-trigger',
            'relative flex shrink-0 items-center justify-center border-r border-zinc-200 bg-zinc-50 p-1.5',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-zinc-950/10',
            'dark:border-zinc-800 dark:bg-zinc-900/80 dark:focus-visible:ring-zinc-300/20',
            $swatchWidth,
            $this->disabled ? 'cursor-not-allowed' : 'cursor-pointer',
        ])->filter()->implode(' ');

        $previewClasses = collect([
            'color-picker__preview',
            'block size-full min-h-[1.125rem] min-w-[1.125rem] rounded-[3px] ring-1 ring-inset ring-zinc-950/10 dark:ring-white/15',
            $isSmall ? 'min-h-4 min-w-4' : null,
        ])->filter()->implode(' ');

        return [
            'triggerClasses' => $triggerClasses,
            'swatchButtonClasses' => $swatchButtonClasses,
            'previewClasses' => $previewClasses,
        ];
    }
}
