<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

it('renders a file upload root with native file input and dropzone', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::file-upload name="avatar" accept="image/*" />
    BLADE);

    expect($html)
        ->toContain('data-file-upload')
        ->toContain('data-file-upload-input')
        ->toContain('type="file"')
        ->toContain('name="avatar"')
        ->toContain('accept="image/*"')
        ->toContain('data-file-upload-dropzone')
        ->toContain('data-file-upload-list')
        ->toContain('data-file-upload-item-template')
        ->toContain('Drop files here or click to browse');
});

it('renders custom dropzone content in shortcut mode', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::file-upload name="docs">
            <x-std::file-upload.dropzone heading="Upload documents" text="PDF up to 10MB" />
        </x-std::file-upload>
    BLADE);

    expect($html)
        ->toContain('Upload documents')
        ->toContain('PDF up to 10MB')
        ->toContain('data-file-upload-list')
        ->toContain('data-file-upload-item-template');
});

it('normalizes multiple field names to array syntax', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::file-upload name="attachments" :multiple="true" />
    BLADE);

    expect($html)
        ->toContain('name="attachments[]"')
        ->toContain('multiple')
        ->toContain('data-file-upload-multiple');
});

it('marks the control invalid when the invalid prop is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::file-upload name="avatar" :invalid="true" />
    BLADE);

    expect($html)
        ->toContain('aria-invalid="true"')
        ->toContain('data-invalid="true"');
});

it('disables the input and dropzone when the disabled prop is true', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::file-upload name="avatar" :disabled="true" />
    BLADE);

    expect($html)
        ->toContain('disabled')
        ->toContain('data-disabled="true"');
});

it('inherits field invalid state from the Field shell', function () {
    $bag = new MessageBag(['avatar' => ['The avatar field is required.']]);
    $errors = new ViewErrorBag;
    $errors->put('default', $bag);
    view()->share('errors', $errors);

    $html = Blade::render(<<<'BLADE'
        <x-std::field name="avatar">
            <x-std::file-upload name="avatar" />
        </x-std::field>
    BLADE);

    expect($html)
        ->toContain('data-invalid="true"')
        ->toContain('aria-invalid="true"');
});

it('renders full compound structure without shortcut', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::file-upload name="docs" :shortcut="false" :multiple="true">
            <x-std::file-upload.dropzone heading="Drop files" text="Any type" />
            <x-std::file-upload.list />
        </x-std::file-upload>
    BLADE);

    expect($html)
        ->toContain('data-file-upload-dropzone')
        ->toContain('Drop files')
        ->toContain('Any type')
        ->toContain('data-file-upload-list')
        ->toContain('data-file-upload-item-template')
        ->toContain('data-file-upload-item-remove');
});

it('renders a static file item with formatted size', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::file-upload.item heading="report.pdf" :size="2048" />
    BLADE);

    expect($html)
        ->toContain('data-file-upload-item')
        ->toContain('report.pdf')
        ->toContain('2.0 KB')
        ->toContain('data-file-upload-item-remove');
});

it('defaults to full width when no custom class is provided', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::file-upload name="avatar" />
    BLADE);

    expect($html)->toContain('file-upload flex min-w-0 flex-col gap-3 w-full');
});

it('allows width utilities on the root to override the default w-full', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::file-upload name="avatar" class="w-80" />
    BLADE);

    expect($html)->toContain('file-upload flex min-w-0 flex-col gap-3 w-80');
});

it('wires the control id to the native input', function () {
    $html = Blade::render(<<<'BLADE'
        <x-std::file-upload name="avatar" file-upload-id="avatar-upload" />
    BLADE);

    expect($html)
        ->toContain('id="avatar-upload"')
        ->toContain('data-file-upload-id="avatar-upload"');
});
