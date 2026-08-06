<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Tabs;

use InvalidArgumentException;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Content extends StdComponent
{
    public function __construct(
        public mixed $value = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.tabs.content';
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
