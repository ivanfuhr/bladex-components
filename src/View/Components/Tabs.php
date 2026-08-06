<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

use Illuminate\Support\Str;

final class Tabs extends StdComponent
{
    public function __construct(
        public mixed $defaultValue = null,
        public mixed $orientation = 'horizontal',
        public mixed $variant = 'default',
        public mixed $tabsId = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.tabs.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $tabsId = filled($this->tabsId)
            ? $this->tabsId
            : 'tabs-'.Str::uuid()->toString();

        return [
            'tabsId' => $tabsId,
            'variant' => filled($this->variant) ? $this->variant : 'default',
        ];
    }
}
