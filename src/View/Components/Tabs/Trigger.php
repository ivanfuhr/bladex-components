<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Tabs;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Trigger extends StencilComponent
{
    public function __construct(
        public mixed $value = null,
        public bool $disabled = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.tabs.trigger';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $defaultValue = $this->aware('defaultValue');
        $variant = $this->aware('variant', 'default');
        $tabsId = $this->aware('tabsId');

        $isSelected = filled($defaultValue) && (string) $this->value === (string) $defaultValue;

        $triggerId = $this->attributes->get('id')
            ?? (filled($tabsId) ? $tabsId.'-tab-'.$this->value : null);
        $panelId = filled($tabsId) ? $tabsId.'-panel-'.$this->value : null;

        $triggerClasses = match ($variant) {
            'pills' => 'rounded-full px-3 py-1.5 text-sm font-medium data-[state=active]:bg-zinc-900 data-[state=active]:text-white dark:data-[state=active]:bg-zinc-100 dark:data-[state=active]:text-zinc-900',
            'line' => 'border-b-2 border-transparent px-1 py-2 text-sm font-medium data-[state=active]:border-zinc-900 dark:data-[state=active]:border-zinc-100',
            default => 'rounded-md px-3 py-1.5 text-sm font-medium data-[state=active]:bg-white data-[state=active]:text-zinc-950 data-[state=active]:shadow-sm dark:data-[state=active]:bg-zinc-950 dark:data-[state=active]:text-zinc-50',
        };

        return [
            'isSelected' => $isSelected,
            'isDisabled' => $this->disabled,
            'triggerId' => $triggerId,
            'panelId' => $panelId,
            'triggerClasses' => $triggerClasses,
        ];
    }
}
