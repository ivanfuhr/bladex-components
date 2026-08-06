<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Accordion;

use Illuminate\Support\Str;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Content extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.accordion.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $isExpanded = (bool) $this->aware('expanded', false);
        $triggerId = $this->aware('triggerId');
        $contentId = $this->aware('contentId') ?? 'accordion-content-'.Str::uuid()->toString();

        return [
            'transition' => (bool) $this->aware('transition', false),
            'isExpanded' => $isExpanded,
            'triggerId' => $triggerId,
            'resolvedContentId' => $contentId,
        ];
    }
}
