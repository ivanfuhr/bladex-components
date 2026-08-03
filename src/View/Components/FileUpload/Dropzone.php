<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\FileUpload;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Dropzone extends StencilComponent
{
    public function __construct(
        public mixed $heading = null,
        public mixed $text = null,
        public bool $inline = false,
        public bool $invalid = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.file-upload.dropzone';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $size = $data['size'] ?? null;
        $disabled = (bool) ($data['disabled'] ?? false);

        $isInvalid = $this->invalid || $fieldInvalid;

        $resolvedHeading = filled($this->heading)
            ? (string) $this->heading
            : __('Drop files here or click to browse');

        $resolvedText = filled($this->text) ? (string) $this->text : null;

        $dropzoneClasses = collect([
            'file-upload__dropzone',
            'group relative flex w-full cursor-pointer flex-col items-center justify-center gap-2 rounded-md border border-dashed border-zinc-300 bg-white px-4 text-center shadow-sm transition-colors',
            'hover:border-zinc-400 hover:bg-zinc-50',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-0',
            'dark:border-zinc-700 dark:bg-zinc-950 dark:hover:border-zinc-500 dark:hover:bg-zinc-900',
            'dark:focus-visible:ring-zinc-300/20',
            'data-[dragging=true]:border-zinc-900 data-[dragging=true]:bg-zinc-50',
            'dark:data-[dragging=true]:border-zinc-50 dark:data-[dragging=true]:bg-zinc-900',
            stencil_invalid_field_classes(),
            $this->inline ? 'min-h-16 flex-row gap-3 py-3' : 'min-h-36 py-8',
            $size === 'sm' ? ($this->inline ? 'min-h-12 py-2' : 'min-h-28 py-6') : null,
            $isInvalid ? 'border-red-500 dark:border-red-500' : null,
            $disabled ? 'pointer-events-none cursor-not-allowed opacity-50' : null,
        ])->filter()->implode(' ');

        $dropzoneAttributes = stencil_apply_interaction($this->attributes
            ->except(['heading', 'text', 'inline'])
            ->class($dropzoneClasses)
            ->merge([
                'type' => 'button',
                'data-file-upload-dropzone' => true,
                'data-dragging' => 'false',
            ]),
            nativeDisabled: true,
        );

        if ($disabled) {
            $dropzoneAttributes = $dropzoneAttributes->merge(['disabled' => true]);
        }

        if ($isInvalid) {
            $dropzoneAttributes = $dropzoneAttributes->merge(['aria-invalid' => 'true']);
        }

        return [
            'isInvalid' => $isInvalid,
            'resolvedHeading' => $resolvedHeading,
            'resolvedText' => $resolvedText,
            'dropzoneAttributes' => $dropzoneAttributes,
            'iconClasses' => $size === 'sm' ? 'size-5' : 'size-6',
            'size' => $size,
            'inline' => $this->inline,
        ];
    }
}
