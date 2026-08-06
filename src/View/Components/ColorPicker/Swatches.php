<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\ColorPicker;

use Illuminate\Support\Facades\View;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Swatches extends StdComponent
{
    public function __construct(
        public mixed $swatches = null,
        public mixed $swatchPalette = [],
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.color-picker.swatches';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $palette = match (true) {
            is_array($this->swatches) => collect($this->swatches)
                ->map(function (mixed $swatch): array {
                    if (is_array($swatch)) {
                        return [
                            'value' => (string) ($swatch[0] ?? $swatch['value'] ?? '#000000'),
                            'label' => (string) ($swatch[1] ?? $swatch['label'] ?? $swatch[0] ?? '#000000'),
                        ];
                    }

                    return [
                        'value' => (string) $swatch,
                        'label' => (string) $swatch,
                    ];
                })
                ->filter(fn (array $swatch) => preg_match('/^#[0-9a-fA-F]{6}$/', $swatch['value']) === 1)
                ->values()
                ->all(),
            default => collect((array) $this->swatchPalette)
                ->map(function (mixed $swatch): array {
                    if (is_array($swatch) && isset($swatch['value'])) {
                        return $swatch;
                    }

                    if (is_array($swatch)) {
                        return [
                            'value' => (string) ($swatch[0] ?? '#000000'),
                            'label' => (string) ($swatch[1] ?? $swatch[0] ?? '#000000'),
                        ];
                    }

                    return [
                        'value' => (string) $swatch,
                        'label' => (string) $swatch,
                    ];
                })
                ->filter(fn (array $swatch) => preg_match('/^#[0-9a-fA-F]{6}$/', $swatch['value']) === 1)
                ->values()
                ->all(),
        };

        return [
            'disabled' => (bool) View::getConsumableComponentData('disabled', false),
            'palette' => $palette,
        ];
    }
}
