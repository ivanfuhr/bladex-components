<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Command;

use Illuminate\Support\Facades\View;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Item extends StencilComponent
{
    public function __construct(
        public mixed $value = null,
        public bool $disabled = false,
        public mixed $href = null,
        public mixed $kbd = null,
        public mixed $icon = null,
        public bool $keepOpen = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.command.item';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $isDisabled = $this->disabled;
        $useLink = filled($this->href);
        $tag = $useLink ? 'a' : 'button';

        $resolvedCommandId = View::getConsumableComponentData('commandId', null);
        $resolvedCommandId = filled($resolvedCommandId) ? $resolvedCommandId : null;
        $optionId = filled($resolvedCommandId) && filled($this->value)
            ? $resolvedCommandId.'-option-'.preg_replace('/[^a-zA-Z0-9_-]/', '-', (string) $this->value)
            : null;

        $keywords = filled($this->value) ? (string) $this->value : '';

        $itemAttributes = $this->attributes
            ->class([
                'command__item',
                'relative flex w-full cursor-default items-center gap-2 rounded-md px-2 py-1.5 text-sm outline-none select-none',
                'text-zinc-950 dark:text-zinc-50',
                'hover:bg-zinc-100 data-[highlighted]:bg-zinc-100 dark:hover:bg-zinc-800 dark:data-[highlighted]:bg-zinc-800',
                '[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=size-])]:size-4',
                '[&_svg:not([class*=text-])]:text-zinc-500 dark:[&_svg:not([class*=text-])]:text-zinc-400',
                $isDisabled ? 'pointer-events-none opacity-50' : null,
            ])
            ->merge([
                'type' => $useLink ? null : 'button',
                'href' => $useLink ? $this->href : null,
                'role' => 'option',
                'tabindex' => '-1',
                'data-command-item' => true,
                'data-value' => filled($this->value) ? $this->value : null,
                'data-keywords' => $keywords !== '' ? $keywords : null,
                'data-keep-open' => $this->keepOpen ? 'true' : null,
                'data-disabled' => $isDisabled ? 'true' : null,
                'aria-disabled' => $isDisabled ? 'true' : null,
                'aria-selected' => 'false',
                'disabled' => (! $useLink && $isDisabled) ? true : null,
            ]);

        if (filled($optionId)) {
            $itemAttributes = $itemAttributes->merge(['id' => $optionId]);
        }

        return [
            'tag' => $tag,
            'itemAttributes' => $itemAttributes,
        ];
    }
}
