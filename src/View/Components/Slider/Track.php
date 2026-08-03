<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Slider;

use Illuminate\Support\Facades\View;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Track extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.slider.track';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $size = View::getConsumableComponentData('size', null);

        return [
            'railClasses' => stencil_slider_track_classes($size),
        ];
    }
}
