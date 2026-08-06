<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\FileUpload;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class ListView extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.file-upload.list';
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
