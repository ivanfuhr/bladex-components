<div {{ $rootAttributes }}>
    <div class="sr-only" aria-live="polite" aria-atomic="true" data-file-upload-status></div>

    <input {{ $inputAttributes }} />

    @if ($shortcut)
        @if ($slot->isEmpty())
            <x-std::file-upload.dropzone :heading="$dropzoneHeading" :text="$dropzoneText" :invalid="$invalid" />
        @else
            {{ $slot }}
        @endif

        <x-std::file-upload.list />

        <template data-file-upload-item-template>
            <x-std::file-upload.item />
        </template>
    @else
        {{ $slot }}

        <template data-file-upload-item-template>
            <x-std::file-upload.item />
        </template>
    @endif
</div>
