<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Command;

use Illuminate\Support\Str;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Group extends StdComponent
{
    public function __construct(
        public mixed $heading = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.command.group';
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
