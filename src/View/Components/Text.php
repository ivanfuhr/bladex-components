<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Text extends StdComponent
{
    public function __construct(
        public mixed $size = null,
        public mixed $variant = null,
        public mixed $color = null,
        public bool $inline = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.text.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'classes' => std_text_classes($this->size, $this->variant, $this->color),
        ];
    }
}
