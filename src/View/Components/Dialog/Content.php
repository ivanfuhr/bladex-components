<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Dialog;

use Illuminate\View\ComponentSlot;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Content extends StdComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $size = 'default',
        public bool $flyout = false,
        public mixed $flyoutPosition = 'right',
        public bool $dismissible = true,
        public bool $closable = true,
        public bool $alert = false,
        public bool $open = false,
        public bool $preview = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.dialog.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $isFlyout = $this->flyout;
        $position = in_array($this->flyoutPosition, ['right', 'left', 'bottom'], true)
            ? $this->flyoutPosition
            : 'right';

        $dialogClasses = collect([
            'dialog__content',
            'fixed z-50 border border-zinc-200 bg-white p-0 text-zinc-950 shadow-xl',
            'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
            'backdrop:bg-zinc-950/50 backdrop:backdrop-blur-[2px]',
            'motion-safe:transition-[opacity,transform] motion-safe:duration-200 motion-safe:ease-[cubic-bezier(0.16,1,0.3,1)]',
            'open:opacity-100 open:motion-safe:scale-100',
            'opacity-0 motion-safe:scale-[0.98]',
        ]);

        if ($isFlyout) {
            $dialogClasses->push('m-0 h-dvh max-h-dvh w-full max-w-md rounded-none');
            $dialogClasses->push(match ($position) {
                'left' => 'left-0 right-auto top-0 translate-x-0 translate-y-0',
                'bottom' => 'bottom-0 left-0 right-0 top-auto h-auto max-h-[85dvh] w-full max-w-none translate-x-0 translate-y-0 rounded-t-2xl',
                default => 'left-auto right-0 top-0 translate-x-0 translate-y-0',
            });
        } else {
            $dialogClasses->push('left-1/2 top-1/2 w-[calc(100%-2rem)] -translate-x-1/2 -translate-y-1/2 rounded-xl');
            $dialogClasses->push($this->size === 'sm' ? 'max-w-sm' : 'max-w-lg');
        }

        $panelClasses = collect([
            'dialog__panel',
            'relative flex max-h-[min(85dvh,calc(100dvh-2rem))] flex-col p-6',
        ]);

        $closeButtonClasses = 'absolute right-4 top-4 inline-flex size-8 items-center justify-center rounded-md text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20';

        $slot = $data['slot'] ?? null;
        $slotHtml = $slot instanceof ComponentSlot ? $slot->toHtml() : (string) $slot;

        $titleId = null;
        $descriptionId = null;

        if (preg_match('/\sdata-dialog-title="([^"]+)"/', $slotHtml, $titleMatch) === 1) {
            $titleId = $titleMatch[1];
        }

        if (preg_match('/\sdata-dialog-description="([^"]+)"/', $slotHtml, $descriptionMatch) === 1) {
            $descriptionId = $descriptionMatch[1];
        }

        $previewPanelClasses = collect([
            'dialog__content',
            'relative z-10 w-full rounded-xl border border-zinc-200 bg-white p-0 text-zinc-950 shadow-xl',
            'dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50',
            $this->size === 'sm' ? 'max-w-sm' : 'max-w-lg',
        ])->implode(' ');

        return [
            'isFlyout' => $isFlyout,
            'position' => $position,
            'dialogClasses' => $dialogClasses,
            'panelClasses' => $panelClasses,
            'closeButtonClasses' => $closeButtonClasses,
            'isPreview' => $this->preview,
            'isOpen' => $this->open,
            'slotHtml' => $slotHtml,
            'titleId' => $titleId,
            'descriptionId' => $descriptionId,
            'previewPanelClasses' => $previewPanelClasses,
        ];
    }
}
