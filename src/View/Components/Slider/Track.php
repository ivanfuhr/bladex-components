<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Slider;

use Illuminate\Support\Facades\View;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Track extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.slider.track';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $size = View::getConsumableComponentData('size', null);

        return [
            'railClasses' => std_slider_track_classes($size),
        ];
    }
}
