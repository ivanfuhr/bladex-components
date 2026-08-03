<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\ColorPicker;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Content extends StencilComponent
{
    public function __construct(
        public mixed $popoverId = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.color-picker.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'popoverClasses' => collect([
                'color-picker__popover',
                'z-[200] flex w-[min(18rem,calc(100vw-1rem))] flex-col gap-3 rounded-md border border-zinc-200 bg-white p-3 shadow-md',
                'dark:border-zinc-800 dark:bg-zinc-950',
            ])->implode(' '),
        ];
    }
}
