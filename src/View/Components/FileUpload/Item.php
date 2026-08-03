<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\FileUpload;

use Illuminate\Support\Facades\View;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Item extends StencilComponent
{
    public function __construct(
        public mixed $heading = null,
        public mixed $text = null,
        public mixed $size = null,
        public bool $invalid = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.file-upload.item';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $disabled = (bool) View::getConsumableComponentData('disabled', false);

        $resolvedHeading = filled($this->heading) ? (string) $this->heading : null;
        $resolvedText = filled($this->text) ? (string) $this->text : $this->formatBytes($this->size);

        $itemClasses = collect([
            'file-upload__item',
            'flex w-full min-w-0 items-center gap-3 rounded-md border border-zinc-200 bg-white px-3 py-2 shadow-sm',
            'dark:border-zinc-800 dark:bg-zinc-950',
            $this->invalid ? 'border-red-500 dark:border-red-500' : null,
        ])->filter()->implode(' ');

        $itemAttributes = $this->attributes
            ->class($itemClasses)
            ->merge([
                'data-file-upload-item' => true,
            ]);

        if ($this->invalid) {
            $itemAttributes = $itemAttributes->merge(['data-invalid' => 'true']);
        }

        return [
            'disabled' => $disabled,
            'resolvedHeading' => $resolvedHeading,
            'resolvedText' => $resolvedText,
            'itemAttributes' => $itemAttributes,
        ];
    }

    private function formatBytes(int|float|string|null $bytes): ?string
    {
        if ($bytes === null || $bytes === '') {
            return null;
        }

        $value = (float) $bytes;

        if ($value < 0) {
            return null;
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $index = 0;

        while ($value >= 1024 && $index < count($units) - 1) {
            $value /= 1024;
            $index++;
        }

        $precision = $index === 0 ? 0 : 1;

        return number_format($value, $precision).' '.$units[$index];
    }
}
