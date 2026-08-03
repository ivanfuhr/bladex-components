<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Repeater;

use Illuminate\Support\Facades\View;
use InvalidArgumentException;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Item extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.repeater.item';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $name = View::getConsumableComponentData('name', null);

        if (! filled($name)) {
            throw new InvalidArgumentException('The repeater.item component must be used inside a repeater with a [name] attribute.');
        }

        $invalid = (bool) View::getConsumableComponentData('invalid', false);
        $fieldInvalid = (bool) View::getConsumableComponentData('fieldInvalid', false);
        $isInvalid = $invalid || $fieldInvalid;

        $stackKey = preg_replace('/[^a-zA-Z0-9_-]/', '-', (string) $name);
        $stackName = 'repeater-item-template-'.$stackKey;

        $itemClasses = collect([
            'repeater__item',
            'flex flex-col gap-3 rounded-md border border-zinc-200 bg-white p-4 shadow-sm',
            'dark:border-zinc-800 dark:bg-zinc-950',
            $isInvalid ? 'border-red-500 dark:border-red-500' : null,
        ])->filter()->implode(' ');

        return [
            'stackName' => $stackName,
            'itemClasses' => $itemClasses,
        ];
    }
}
