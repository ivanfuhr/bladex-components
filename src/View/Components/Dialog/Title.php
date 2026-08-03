<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Dialog;

use Illuminate\Support\Str;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Title extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.dialog.title';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'titleId' => $this->attributes->get('id') ?? 'dialog-title-'.Str::uuid()->toString(),
        ];
    }
}
