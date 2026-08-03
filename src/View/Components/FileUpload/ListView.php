<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\FileUpload;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class ListView extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.file-upload.list';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'listClasses' => collect([
                'file-upload__list',
                'flex flex-col gap-2',
            ])->implode(' '),
        ];
    }
}
