<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Accordion;

use Illuminate\Support\Str;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Trigger extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.accordion.trigger';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $isExpanded = (bool) $this->aware('expanded', false);
        $isDisabled = (bool) $this->aware('disabled', false);
        $variant = $this->aware('variant');
        $contentId = $this->aware('contentId');
        $triggerId = $this->aware('triggerId') ?? 'accordion-trigger-'.Str::uuid()->toString();

        return [
            'isExpanded' => $isExpanded,
            'isDisabled' => $isDisabled,
            'isReverse' => $variant === 'reverse',
            'resolvedTriggerId' => $triggerId,
            'resolvedContentId' => $contentId,
        ];
    }
}
