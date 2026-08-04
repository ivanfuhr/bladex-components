<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Grid;

use Ivanfuhr\Stencil\Support\Grid\GridClassMap;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Item extends StencilComponent
{
    public function __construct(
        public mixed $span = 1,
        public mixed $sm = null,
        public mixed $md = null,
        public mixed $lg = null,
        public mixed $xl = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.grid.item';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $classMap = app(GridClassMap::class);
        $container = (bool) $this->aware('container', true);
        $span = $classMap->normalizeSpan($this->span) ?? 1;

        $mergedAttributes = $this->attributes
            ->except(['2xl'])
            ->class($classMap->itemClasses(
                span: $span,
                breakpointSpans: $this->breakpointSpans($classMap),
                container: $container,
            ))
            ->merge([
                'data-grid-item' => true,
            ]);

        return [
            'mergedAttributes' => $mergedAttributes,
        ];
    }

    /**
     * @return array<string, int|string|null>
     */
    private function breakpointSpans(GridClassMap $classMap): array
    {
        return [
            'sm' => $classMap->normalizeSpan($this->sm),
            'md' => $classMap->normalizeSpan($this->md),
            'lg' => $classMap->normalizeSpan($this->lg),
            'xl' => $classMap->normalizeSpan($this->xl),
            '2xl' => $classMap->normalizeSpan($this->attributes->get('2xl')),
        ];
    }
}
