<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

use Illuminate\Support\Str;

final class Collapsible extends StdComponent
{
    public string $triggerId;

    public string $contentId;

    public function __construct(
        public bool $open = false,
        public bool $disabled = false,
        public bool $transition = false,
        ?string $triggerId = null,
        ?string $contentId = null,
    ) {
        $baseId = 'collapsible-'.Str::uuid()->toString();

        $this->triggerId = $triggerId ?? $baseId.'-trigger';
        $this->contentId = $contentId ?? $baseId.'-content';
    }

    protected function stdView(): string
    {
        return 'std-components::components.collapsible.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'isOpen' => $this->open,
            'isDisabled' => $this->disabled,
        ];
    }
}
