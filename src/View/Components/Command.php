<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\Support\Str;

final class Command extends StencilComponent
{
    public function __construct(
        public mixed $commandId = null,
        public mixed $listboxId = null,
        public mixed $empty = null,
        public mixed $placeholder = null,
        public bool $shortcut = true,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.command.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $resolvedCommandId = filled($this->commandId)
            ? $this->commandId
            : 'command-'.Str::uuid()->toString();
        $resolvedListboxId = filled($this->listboxId) ? $this->listboxId : $resolvedCommandId.'-listbox';

        $emptyMessage = filled($this->empty)
            ? (string) $this->empty
            : __('No results found.');

        $rootAttributes = $this->attributes
            ->class([
                'command',
                'flex w-full flex-col overflow-hidden rounded-xl bg-white text-zinc-950',
                'dark:bg-zinc-950 dark:text-zinc-50',
            ])
            ->merge([
                'data-command' => true,
                'data-command-id' => $resolvedCommandId,
                'data-command-listbox-id' => $resolvedListboxId,
            ]);

        return [
            'resolvedCommandId' => $resolvedCommandId,
            'resolvedListboxId' => $resolvedListboxId,
            'emptyMessage' => $emptyMessage,
            'rootAttributes' => $rootAttributes,
        ];
    }
}
