<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Command;

use Illuminate\Support\Str;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Dialog extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $title = null,
        public mixed $description = null,
        public mixed $shortcut = null,
        public bool $closable = false,
        public bool $dismissible = true,
        public bool $open = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.command.dialog';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $resolvedTitle = filled($this->title)
            ? (string) $this->title
            : __('Command Palette');
        $resolvedDescription = filled($this->description)
            ? (string) $this->description
            : __('Search for a command to run…');

        $dialogId = 'command-dialog-'.Str::uuid()->toString();
        $titleId = $dialogId.'-title';
        $descriptionId = $dialogId.'-description';

        $normalizedShortcut = filled($this->shortcut)
            ? strtolower(str_replace([' ', '+'], ['', '.'], (string) $this->shortcut))
            : null;

        if ($normalizedShortcut !== null) {
            $normalizedShortcut = str_replace(['cmd.', 'command.'], 'meta.', $normalizedShortcut);
        }

        $dialogClasses = collect([
            'command__dialog',
            'dialog__content',
            'fixed left-1/2 top-[12vh] z-50 w-[calc(100%-2rem)] max-w-lg -translate-x-1/2 overflow-hidden rounded-xl border border-zinc-200 bg-white p-0 text-zinc-950 shadow-xl',
            'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
            'backdrop:bg-zinc-950/50 backdrop:backdrop-blur-[2px]',
            'motion-safe:transition-[opacity,transform] motion-safe:duration-200 motion-safe:ease-[cubic-bezier(0.16,1,0.3,1)]',
            'open:opacity-100 open:motion-safe:scale-100',
            'opacity-0 motion-safe:scale-[0.98]',
        ])->implode(' ');

        $closeButtonClasses = 'absolute right-3 top-2.5 z-10 inline-flex size-8 items-center justify-center rounded-md text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20';

        return [
            'resolvedTitle' => $resolvedTitle,
            'resolvedDescription' => $resolvedDescription,
            'titleId' => $titleId,
            'descriptionId' => $descriptionId,
            'normalizedShortcut' => $normalizedShortcut,
            'dialogClasses' => $dialogClasses,
            'closeButtonClasses' => $closeButtonClasses,
        ];
    }
}
