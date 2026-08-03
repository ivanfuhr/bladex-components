<button {{ $dropzoneAttributes }}>
    <span class="flex size-10 items-center justify-center rounded-full bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
        <x-ui::icon name="upload" class="{{ $iconClasses }}" data-file-upload-dropzone-icon />
    </span>

    <span class="flex min-w-0 flex-col gap-0.5 {{ $inline ? 'items-start text-left' : 'items-center' }}">
        <x-ui::text
            :size="$size === 'sm' ? 'sm' : null"
            variant="strong"
            inline
            data-file-upload-dropzone-heading
        >{{ $resolvedHeading }}</x-ui::text>

        @if (filled($resolvedText))
            <x-ui::text
                size="sm"
                variant="subtle"
                inline
                data-file-upload-dropzone-text
            >{{ $resolvedText }}</x-ui::text>
        @endif
    </span>
</button>
