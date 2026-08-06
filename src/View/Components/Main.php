<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Main extends StdComponent
{
    public function __construct(
        public bool $container = false,
        public string $type = 'hover',
        public int $scrollHideDelay = 600,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.main.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $type = match ($this->type) {
            'always', 'scroll', 'auto', 'hover' => $this->type,
            default => 'hover',
        };

        $scrollHideDelay = max(0, $this->scrollHideDelay);

        $shellAttributes = $this->attributes
            ->only(['id', 'tabindex', 'role'])
            ->merge($this->attributes->whereStartsWith('aria-')->getAttributes())
            ->class([
                'app-main',
                'flex',
                'min-h-0',
                'flex-1',
                'flex-col',
                'overflow-hidden',
            ])
            ->merge([
                'data-main' => true,
            ]);

        $contentAttributes = $this->attributes
            ->except(['id', 'tabindex', 'role'])
            ->whereDoesntStartWith('aria-')
            ->class([
                'app-main__content',
                // Uniform inset padding under the shell header — avoid p-4 pt-0 (uneven).
                'flex flex-col gap-4 p-4',
                $this->container ? 'mx-auto w-full max-w-7xl' : null,
            ]);

        return [
            'type' => $type,
            'scrollHideDelay' => $scrollHideDelay,
            'shellAttributes' => $shellAttributes,
            'contentAttributes' => $contentAttributes,
        ];
    }
}
