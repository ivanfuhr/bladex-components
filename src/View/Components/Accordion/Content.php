<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Accordion;

use Illuminate\Support\Str;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Content extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.accordion.content';
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
