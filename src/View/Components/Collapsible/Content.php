<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Collapsible;

use Illuminate\Support\Str;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Content extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.collapsible.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $triggerId = $this->aware('triggerId');
        $contentId = $this->aware('contentId') ?? 'collapsible-content-'.Str::uuid()->toString();

        return [
            'isOpen' => (bool) $this->aware('open', false),
            'transition' => (bool) $this->aware('transition', false),
            'triggerId' => $triggerId,
            'resolvedContentId' => $contentId,
        ];
    }
}
