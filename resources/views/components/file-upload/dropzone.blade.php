@aware([
    'size' => null,
    'invalid' => false,
    'fieldInvalid' => false,
    'disabled' => false,
    'controlId' => null,
    'fileUploadId' => null,
])

@props([
    'heading' => null,
    'text' => null,
    'inline' => false,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $isInvalid = $invalid || $fieldInvalid;

    $resolvedHeading = filled($heading)
        ? (string) $heading
        : __('stencil::messages.file_upload_heading');

    $resolvedText = filled($text) ? (string) $text : null;

    $resolvedControlId = filled($controlId)
        ? $controlId
        : (filled($fileUploadId) ? $fileUploadId : null);

    $dropzoneClasses = collect([
        'file-upload__dropzone',
        'group relative flex w-full cursor-pointer flex-col items-center justify-center gap-2 rounded-md border border-dashed border-zinc-300 bg-white px-4 text-center shadow-sm transition-colors',
        'hover:border-zinc-400 hover:bg-zinc-50',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-0',
        'dark:border-zinc-700 dark:bg-zinc-950 dark:hover:border-zinc-500 dark:hover:bg-zinc-900',
        'dark:focus-visible:ring-zinc-300/20',
        'data-[dragging=true]:border-zinc-900 data-[dragging=true]:bg-zinc-50',
        'dark:data-[dragging=true]:border-zinc-50 dark:data-[dragging=true]:bg-zinc-900',
        $formControl->invalidFieldClasses(),
        $inline ? 'min-h-16 flex-row gap-3 py-3' : 'min-h-36 py-8',
        $size === 'sm' ? ($inline ? 'min-h-12 py-2' : 'min-h-28 py-6') : null,
        $isInvalid ? 'border-red-500 dark:border-red-500' : null,
        $disabled ? 'pointer-events-none cursor-not-allowed opacity-50' : null,
    ])->filter()->implode(' ');

    $dropzoneAttributes = $interactionState->apply(
        $attributes
            ->except(['heading', 'text', 'inline'])
            ->class($dropzoneClasses)
            ->merge([
                'type' => 'button',
                'data-file-upload-dropzone' => true,
                'data-dragging' => 'false',
            ]),
        ['nativeDisabled' => true],
    );

    if ($disabled) {
        $dropzoneAttributes = $dropzoneAttributes->merge(['disabled' => true]);
    }

    if ($isInvalid) {
        $dropzoneAttributes = $dropzoneAttributes->merge(['aria-invalid' => 'true']);
    }

    if (filled($resolvedControlId)) {
        $dropzoneAttributes = $dropzoneAttributes->merge([
            'aria-controls' => $resolvedControlId,
        ]);
    }

    $iconClasses = $size === 'sm' ? 'size-5' : 'size-6';
@endphp

<button {{ $dropzoneAttributes }}>
    <span class="flex size-10 items-center justify-center rounded-full bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
        <x-stencil::icon name="upload" class="{{ $iconClasses }}" data-file-upload-dropzone-icon />
    </span>

    <span class="flex min-w-0 flex-col gap-0.5 {{ $inline ? 'items-start text-left' : 'items-center' }}">
        <x-stencil::text
            :size="$size === 'sm' ? 'sm' : null"
            variant="strong"
            inline
            data-file-upload-dropzone-heading
        >{{ $resolvedHeading }}</x-stencil::text>

        @if (filled($resolvedText))
            <x-stencil::text
                size="sm"
                variant="subtle"
                inline
                data-file-upload-dropzone-text
            >{{ $resolvedText }}</x-stencil::text>
        @endif
    </span>
</button>
