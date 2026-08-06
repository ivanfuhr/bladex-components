<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Command;

use Illuminate\Support\Facades\View;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class ListView extends StdComponent
{
    public function __construct(
        public mixed $listboxId = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.command.list';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $resolvedCommandId = View::getConsumableComponentData('commandId', null);
        $resolvedCommandId = filled($resolvedCommandId) ? $resolvedCommandId : null;

        $resolvedListboxId = filled($this->listboxId)
            ? $this->listboxId
            : (filled($resolvedCommandId) ? $resolvedCommandId.'-listbox' : null);

        $listAttributes = $this->attributes
            ->class([
                'command__list',
                'max-h-[min(300px,50vh)] scroll-py-1 overflow-x-hidden overflow-y-auto p-1',
            ])
            ->merge([
                'role' => 'listbox',
                'tabindex' => '-1',
                'data-command-list' => true,
            ]);

        if (filled($resolvedListboxId)) {
            $listAttributes = $listAttributes->merge(['id' => $resolvedListboxId]);
        }

        return [
            'listAttributes' => $listAttributes,
        ];
    }
}
