<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Collapsible;

use Illuminate\Support\Str;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Trigger extends StencilComponent
{
    public function __construct(
        public bool $asChild = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.collapsible.trigger';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $triggerId = $this->aware('triggerId') ?? 'collapsible-trigger-'.Str::uuid()->toString();
        $contentId = $this->aware('contentId');

        return [
            'isOpen' => (bool) $this->aware('open', false),
            'isDisabled' => (bool) $this->aware('disabled', false),
            'resolvedTriggerId' => $triggerId,
            'resolvedContentId' => $contentId,
        ];
    }
}
