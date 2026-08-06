<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Accordion;

use Illuminate\Support\Str;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Item extends StdComponent
{
    public function __construct(
        public mixed $value = null,
        public mixed $heading = null,
        public bool $expanded = false,
        public bool $disabled = false,
        public mixed $triggerId = null,
        public mixed $contentId = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.accordion.item';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $itemValue = filled($this->value)
            ? (string) $this->value
            : 'accordion-item-'.Str::uuid()->toString();

        $itemId = 'accordion-'.Str::uuid()->toString();

        return [
            'itemValue' => $itemValue,
            'isExpanded' => $this->expanded,
            'isDisabled' => $this->disabled,
            'triggerId' => $this->triggerId ?? $itemId.'-trigger',
            'contentId' => $this->contentId ?? $itemId.'-content',
        ];
    }
}
