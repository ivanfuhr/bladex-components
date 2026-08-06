<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

use Illuminate\View\ComponentAttributeBag;
use Ivanfuhr\StdComponents\Support\Grid\GridClassMap;

final class Grid extends StdComponent
{
    public function __construct(
        public int $cols = 1,
        public mixed $sm = null,
        public mixed $md = null,
        public mixed $lg = null,
        public mixed $xl = null,
        public mixed $gap = '4',
        public bool $container = true,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.grid.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $classMap = app(GridClassMap::class);

        $gridClasses = $classMap->gridClasses(
            cols: max(1, min(12, $this->cols)),
            breakpointColumns: $this->breakpointColumns($classMap),
            gap: $classMap->normalizeGap($this->gap),
            container: $this->container,
        );

        if ($this->container) {
            $wrapperAttributes = $this->attributes
                ->except(['2xl'])
                ->class($classMap->containerWrapperClasses())
                ->merge([
                    'data-grid' => true,
                    'data-container' => 'true',
                ]);

            $gridAttributes = (new ComponentAttributeBag)->class($gridClasses);

            return [
                'usesContainerWrapper' => true,
                'wrapperAttributes' => $wrapperAttributes,
                'gridAttributes' => $gridAttributes,
            ];
        }

        $mergedAttributes = $this->attributes
            ->except(['2xl'])
            ->class($gridClasses)
            ->merge([
                'data-grid' => true,
                'data-container' => 'false',
            ]);

        return [
            'usesContainerWrapper' => false,
            'mergedAttributes' => $mergedAttributes,
        ];
    }

    /**
     * @return array<string, int|null>
     */
    private function breakpointColumns(GridClassMap $classMap): array
    {
        return [
            'sm' => $classMap->normalizeColumnCount($this->sm),
            'md' => $classMap->normalizeColumnCount($this->md),
            'lg' => $classMap->normalizeColumnCount($this->lg),
            'xl' => $classMap->normalizeColumnCount($this->xl),
            '2xl' => $classMap->normalizeColumnCount($this->attributes->get('2xl')),
        ];
    }
}
