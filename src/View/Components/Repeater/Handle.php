<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Repeater;

use Illuminate\Support\Facades\View;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Handle extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.repeater.handle';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $isDisabled = $this->attributes->has('disabled')
            ? (bool) $this->attributes->get('disabled')
            : (bool) View::getConsumableComponentData('disabled', false);

        $buttonClasses = collect([
            'repeater__handle',
            'inline-flex size-8 shrink-0 cursor-grab items-center justify-center rounded-md text-zinc-400 transition-colors',
            'hover:bg-zinc-100 hover:text-zinc-700',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
            'active:cursor-grabbing',
            'disabled:pointer-events-none disabled:opacity-50',
            'dark:text-zinc-500 dark:hover:bg-zinc-800 dark:hover:text-zinc-200',
            'dark:focus-visible:ring-zinc-300/20',
        ])->implode(' ');

        $buttonAttributes = $this->attributes
            ->except(['disabled'])
            ->class($buttonClasses)
            ->merge([
                'type' => 'button',
                'data-repeater-handle' => true,
                'aria-label' => __('Reorder item'),
                'tabindex' => '-1',
            ]);

        if ($isDisabled) {
            $buttonAttributes = $buttonAttributes->merge(['disabled' => true]);
        }

        return [
            'buttonAttributes' => $buttonAttributes,
        ];
    }
}
