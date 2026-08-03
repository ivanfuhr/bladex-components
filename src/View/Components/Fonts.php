<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Fonts extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.fonts';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'stylesheetUrl' => stencil_google_fonts_url(),
            'cssVariables' => stencil_css_font_variables(),
        ];
    }
}
