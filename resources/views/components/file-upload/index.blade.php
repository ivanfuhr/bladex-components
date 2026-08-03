<div {{ $rootAttributes }}>
    <input {{ $inputAttributes }} />

    @if ($shortcut)
        @if ($slot->isEmpty())
            <x-ui::file-upload.dropzone :heading="$dropzoneHeading" :text="$dropzoneText" :invalid="$invalid" />
        @else
            {{ $slot }}
        @endif

        <x-ui::file-upload.list />

        <template data-file-upload-item-template>
            <x-ui::file-upload.item />
        </template>
    @else
        {{ $slot }}

        <template data-file-upload-item-template>
            <x-ui::file-upload.item />
        </template>
    @endif
</div>
