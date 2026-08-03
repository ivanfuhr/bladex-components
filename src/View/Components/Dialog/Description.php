<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Dialog;

use Illuminate\Support\Str;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Description extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.dialog.description';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'descriptionId' => $this->attributes->get('id') ?? 'dialog-description-'.Str::uuid()->toString(),
        ];
    }
}
