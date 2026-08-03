<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Empty;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Media extends StencilComponent
{
    public function __construct(
        public mixed $variant = 'default',
        public mixed $icon = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.empty.media';
    }

    protected function resolveViewData(array $data = []): array
    {
        $variant = in_array($this->variant, ['default', 'icon'], true) ? $this->variant : 'default';

        return [
            'resolvedVariant' => $variant,
            'variantClasses' => match ($variant) {
                'icon' => "flex size-10 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-zinc-950 dark:bg-zinc-800 dark:text-zinc-50 [&_svg:not([class*='size-'])]:size-6",
                default => 'bg-transparent',
            },
        ];
    }
}
