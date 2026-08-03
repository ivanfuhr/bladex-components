<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Repeater;

use Illuminate\Support\Facades\View;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Add extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.repeater.add';
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
            'repeater__add',
            'inline-flex w-fit items-center justify-center gap-2 rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm font-medium text-zinc-900 shadow-sm transition-colors',
            'hover:bg-zinc-50',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
            'disabled:pointer-events-none disabled:opacity-50',
            'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50 dark:hover:bg-zinc-900',
            'dark:focus-visible:ring-zinc-300/20',
        ])->implode(' ');

        $buttonAttributes = $this->attributes
            ->except(['disabled'])
            ->class($buttonClasses)
            ->merge([
                'type' => 'button',
                'data-repeater-add' => true,
            ]);

        if ($isDisabled) {
            $buttonAttributes = $buttonAttributes->merge(['disabled' => true]);
        }

        return [
            'buttonAttributes' => $buttonAttributes,
        ];
    }
}
