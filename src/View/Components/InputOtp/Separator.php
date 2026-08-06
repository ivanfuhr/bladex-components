<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\InputOtp;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Separator extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.input-otp.separator';
    }
}
