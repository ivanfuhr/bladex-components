<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Tabs;

use InvalidArgumentException;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Content extends StencilComponent
{
    public function __construct(
        public mixed $value = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.tabs.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $tabValue = $this->value ?? $this->attributes->get('value');
        $attributes = $this->attributes->except('value');

        if (! filled($tabValue)) {
            throw new InvalidArgumentException('The tabs content component requires a [value] attribute.');
        }

        $defaultValue = $this->aware('defaultValue');
        $tabsId = $this->aware('tabsId');

        $isSelected = filled($defaultValue) && (string) $tabValue === (string) $defaultValue;
        $panelId = $attributes->get('id')
            ?? (filled($tabsId) ? $tabsId.'-panel-'.$tabValue : null);
        $triggerId = filled($tabsId) ? $tabsId.'-tab-'.$tabValue : null;

        return [
            'attributes' => $attributes,
            'tabValue' => $tabValue,
            'isSelected' => $isSelected,
            'panelId' => $panelId,
            'triggerId' => $triggerId,
        ];
    }
}
