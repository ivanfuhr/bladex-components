<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;

final class FileUpload extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $accept = null,
        public bool $multiple = false,
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $size = null,
        public mixed $heading = null,
        public mixed $text = null,
        public mixed $fileUploadId = null,
        public bool $shortcut = true,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.file-upload.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $controlId = $data['controlId'] ?? null;

        $invalid = $this->invalid || $fieldInvalid || stencil_field_has_errors($this->name);
        $multiple = (bool) $this->multiple;

        $fileUploadId = filled($this->fileUploadId)
            ? $this->fileUploadId
            : (filled($this->name) ? $this->name : 'file-upload-'.Str::uuid()->toString());
        $controlId = filled($controlId) ? $controlId : $fileUploadId;

        $fieldName = $this->name;

        if ($multiple && filled($this->name) && ! Str::endsWith($this->name, '[]')) {
            $fieldName = $this->name.'[]';
        }

        $dropzoneHeading = filled($this->heading)
            ? (string) $this->heading
            : __('Drop files here or click to browse');

        $dropzoneText = filled($this->text) ? (string) $this->text : null;

        $rootAttributes = $this->attributes
            ->class([
                'file-upload flex min-w-0 flex-col gap-3',
                'w-full' => ! filled($this->attributes->get('class')),
            ])
            ->merge([
                'data-file-upload' => true,
                'data-file-upload-id' => $fileUploadId,
                'data-empty' => 'true',
            ]);

        if ($multiple) {
            $rootAttributes = $rootAttributes->merge(['data-file-upload-multiple' => 'true']);
        }

        if ($this->disabled) {
            $rootAttributes = $rootAttributes->merge(['data-disabled' => 'true']);
        }

        if ($invalid) {
            $rootAttributes = $rootAttributes->merge(['data-invalid' => 'true']);
        }

        $inputAttributes = new ComponentAttributeBag([
            'type' => 'file',
            'id' => $controlId,
            'class' => 'sr-only',
            'tabindex' => '-1',
            'data-file-upload-input' => true,
        ]);

        if (filled($fieldName)) {
            $inputAttributes = $inputAttributes->merge(['name' => $fieldName]);
        }

        if (filled($this->accept)) {
            $inputAttributes = $inputAttributes->merge(['accept' => $this->accept]);
        }

        if ($multiple) {
            $inputAttributes = $inputAttributes->merge(['multiple' => true]);
        }

        if ($this->disabled) {
            $inputAttributes = $inputAttributes->merge(['disabled' => true]);
        }

        if ($invalid) {
            $inputAttributes = $inputAttributes->merge(['aria-invalid' => 'true']);
        }

        return [
            'invalid' => $invalid,
            'rootAttributes' => $rootAttributes,
            'inputAttributes' => $inputAttributes,
            'dropzoneHeading' => $dropzoneHeading,
            'dropzoneText' => $dropzoneText,
        ];
    }
}
