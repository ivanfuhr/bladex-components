<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\View\ComponentSlot;
use Ivanfuhr\Stencil\Support\Button\ButtonClassMap;
use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

final class Button extends StencilComponent
{
    public function __construct(
        public string $variant = 'outline',
        public ?string $size = null,
        public ?string $color = null,
        public string $type = 'button',
        public ?string $href = null,
        public ?string $as = null,
        public bool $square = false,
        public mixed $loading = null,
        public mixed $leading = null,
        public mixed $trailing = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.button.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $leading = $data['leading'] ?? $this->leading;
        $trailing = $data['trailing'] ?? $this->trailing;

        [$hasLeading, $leadingContent] = $this->resolveAffix($leading);
        [$hasTrailing, $trailingContent] = $this->resolveAffix($trailing);

        $slot = $data['slot'] ?? null;
        $slotEmpty = $slot === null || (is_object($slot) && method_exists($slot, 'isEmpty') && $slot->isEmpty());
        $iconOnly = $slotEmpty && ($hasLeading || $hasTrailing || $this->square);

        $buttonClasses = app(ButtonClassMap::class)->classes(
            $this->variant,
            $this->size,
            $this->color,
            [
                'hasLeading' => $hasLeading,
                'hasTrailing' => $hasTrailing,
                'square' => $this->square,
                'iconOnly' => $iconOnly,
            ],
        );

        $useLink = filled($this->href) || $this->as === 'a';
        $tag = $useLink ? 'a' : 'button';

        $mergedAttributes = $this->attributes
            ->except(['loading'])
            ->class($buttonClasses)
            ->merge(['data-button' => true]);

        $mergedAttributes = app(InteractionStateAttributes::class)->apply(
            $mergedAttributes,
            [
                'nativeDisabled' => ! $useLink,
                'loading' => $this->loading === true ? true : null,
            ],
        );

        $isLoading = app(InteractionStateAttributes::class)->isLoading($mergedAttributes);

        if ($useLink) {
            $mergedAttributes = $mergedAttributes->merge(['href' => $this->href ?? '#']);
        } else {
            $mergedAttributes = $mergedAttributes->merge(['type' => $this->type]);
        }

        if ($iconOnly) {
            $mergedAttributes = $mergedAttributes->merge(['data-button-icon-only' => true]);
        }

        return [
            'tag' => $tag,
            'mergedAttributes' => $mergedAttributes,
            'hasLeading' => $hasLeading,
            'leadingContent' => $leadingContent,
            'hasTrailing' => $hasTrailing,
            'trailingContent' => $trailingContent,
            'slotEmpty' => $slotEmpty,
            'isLoading' => $isLoading,
        ];
    }

    /**
     * @return array{0: bool, 1: mixed}
     */
    private function resolveAffix(mixed $value): array
    {
        if ($value instanceof ComponentSlot) {
            return [! $value->isEmpty(), $value->isEmpty() ? null : $value];
        }

        if (filled($value)) {
            return [true, $value];
        }

        return [false, null];
    }
}
