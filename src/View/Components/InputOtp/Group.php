<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\InputOtp;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Group extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.input-otp.group';
    }
}
