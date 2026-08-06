<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Fonts extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.fonts';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'stylesheetUrl' => std_google_fonts_url(),
            'cssVariables' => std_css_font_variables(),
        ];
    }
}
