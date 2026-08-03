<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Command;

use Illuminate\Support\Str;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Group extends StencilComponent
{
    public function __construct(
        public mixed $heading = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.command.group';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'headingId' => filled($this->heading)
                ? 'command-group-'.Str::uuid()->toString()
                : null,
        ];
    }
}
