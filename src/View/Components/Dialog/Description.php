<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Dialog;

use Illuminate\Support\Str;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Description extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.dialog.description';
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
