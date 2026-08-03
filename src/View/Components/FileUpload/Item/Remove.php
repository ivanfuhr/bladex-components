<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\FileUpload\Item;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Remove extends StencilComponent
{
    public function __construct(
        public bool $disabled = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.file-upload.item.remove';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $buttonClasses = collect([
            'file-upload__item-remove',
            'inline-flex size-8 shrink-0 items-center justify-center rounded-md text-zinc-500 transition-colors',
            'hover:bg-zinc-100 hover:text-zinc-900',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
            'disabled:pointer-events-none disabled:opacity-50',
            'dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
            'dark:focus-visible:ring-zinc-300/20',
        ])->implode(' ');

        $buttonAttributes = $this->attributes
            ->class($buttonClasses)
            ->merge([
                'type' => 'button',
                'data-file-upload-item-remove' => true,
                'aria-label' => __('Remove'),
            ]);

        if ($this->disabled) {
            $buttonAttributes = $buttonAttributes->merge(['disabled' => true]);
        }

        return [
            'buttonAttributes' => $buttonAttributes,
        ];
    }
}
