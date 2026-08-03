<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Command;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Input extends StencilComponent
{
    public function __construct(
        public mixed $placeholder = null,
        public mixed $commandId = null,
        public mixed $listboxId = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.command.input';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $resolvedPlaceholder = filled($this->placeholder)
            ? (string) $this->placeholder
            : __('Type a command or search…');

        $resolvedCommandId = filled($this->commandId) ? $this->commandId : null;
        $resolvedListboxId = filled($this->listboxId)
            ? $this->listboxId
            : (filled($resolvedCommandId) ? $resolvedCommandId.'-listbox' : null);
        $inputId = filled($resolvedCommandId) ? $resolvedCommandId.'-input' : null;

        $inputAttributes = $this->attributes
            ->class([
                'command__input',
                'flex h-11 w-full min-w-0 bg-transparent py-3 text-sm text-zinc-950 outline-none',
                'placeholder:text-zinc-500 disabled:cursor-not-allowed disabled:opacity-50',
                'dark:text-zinc-50 dark:placeholder:text-zinc-400',
            ])
            ->merge([
                'type' => 'text',
                'role' => 'combobox',
                'aria-autocomplete' => 'list',
                'aria-expanded' => 'true',
                'aria-haspopup' => 'listbox',
                'autocomplete' => 'off',
                'autocorrect' => 'off',
                'spellcheck' => 'false',
                'placeholder' => $resolvedPlaceholder,
                'data-command-input' => true,
                'data-dialog-initial-focus' => true,
            ]);

        if (filled($inputId)) {
            $inputAttributes = $inputAttributes->merge(['id' => $inputId]);
        }

        if (filled($resolvedListboxId)) {
            $inputAttributes = $inputAttributes->merge(['aria-controls' => $resolvedListboxId]);
        }

        return [
            'inputAttributes' => $inputAttributes,
        ];
    }
}
