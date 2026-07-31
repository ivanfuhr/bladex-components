@props([
    'name' => null,
    'accept' => null,
    'multiple' => false,
    'invalid' => false,
    'disabled' => false,
    'size' => null,
    'heading' => null,
    'text' => null,
    'fileUploadId' => null,
    'shortcut' => true,
])

@aware([
    'fieldInvalid' => false,
    'controlId' => null,
])

@php
    use Illuminate\Support\Str;

    $invalid = $invalid || $fieldInvalid;
    $multiple = (bool) $multiple;

    $fileUploadId = filled($fileUploadId)
        ? $fileUploadId
        : (filled($name) ? $name : 'file-upload-'.str_replace('.', '', uniqid('', true)));
    $controlId = filled($controlId) ? $controlId : $fileUploadId;

    $fieldName = $name;

    if ($multiple && filled($name) && ! Str::endsWith($name, '[]')) {
        $fieldName = $name.'[]';
    }

    $dropzoneHeading = filled($heading)
        ? (string) $heading
        : __('stencil::messages.file_upload_heading');

    $dropzoneText = filled($text) ? (string) $text : null;

    $rootAttributes = $attributes
        ->except(['shortcut', 'heading', 'text', 'accept', 'multiple', 'name'])
        ->class([
            'file-upload flex min-w-0 flex-col gap-3',
            'w-full' => ! filled($attributes->get('class')),
        ])
        ->merge([
            'data-file-upload' => true,
            'data-file-upload-id' => $fileUploadId,
            'data-empty' => 'true',
        ]);

    if ($multiple) {
        $rootAttributes = $rootAttributes->merge(['data-file-upload-multiple' => 'true']);
    }

    if ($disabled) {
        $rootAttributes = $rootAttributes->merge(['data-disabled' => 'true']);
    }

    if ($invalid) {
        $rootAttributes = $rootAttributes->merge(['data-invalid' => 'true']);
    }

    $inputAttributes = new \Illuminate\View\ComponentAttributeBag([
        'type' => 'file',
        'id' => $controlId,
        'class' => 'sr-only',
        'tabindex' => '-1',
        'data-file-upload-input' => true,
    ]);

    if (filled($fieldName)) {
        $inputAttributes = $inputAttributes->merge(['name' => $fieldName]);
    }

    if (filled($accept)) {
        $inputAttributes = $inputAttributes->merge(['accept' => $accept]);
    }

    if ($multiple) {
        $inputAttributes = $inputAttributes->merge(['multiple' => true]);
    }

    if ($disabled) {
        $inputAttributes = $inputAttributes->merge(['disabled' => true]);
    }

    if ($invalid) {
        $inputAttributes = $inputAttributes->merge(['aria-invalid' => 'true']);
    }
@endphp

<div {{ $rootAttributes }}>
    <input {{ $inputAttributes }} />

    @if ($shortcut)
        @if ($slot->isEmpty())
            <x-stencil::file-upload.dropzone :heading="$dropzoneHeading" :text="$dropzoneText" />
        @else
            {{ $slot }}
        @endif

        <x-stencil::file-upload.list />

        <template data-file-upload-item-template>
            <x-stencil::file-upload.item />
        </template>
    @else
        {{ $slot }}

        <template data-file-upload-item-template>
            <x-stencil::file-upload.item />
        </template>
    @endif
</div>
