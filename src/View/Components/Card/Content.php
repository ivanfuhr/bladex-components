<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Card;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Content extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.card.content';
    }
}
