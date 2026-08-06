<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Dialog;

use Illuminate\Support\Str;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Title extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.dialog.title';
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
