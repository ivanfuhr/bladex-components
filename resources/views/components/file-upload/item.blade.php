@props([
    'heading' => null,
    'text' => null,
    'size' => null,
    'invalid' => false,
])

@aware([
    'disabled' => false,
])

@php
    $resolvedHeading = filled($heading) ? (string) $heading : null;
    $resolvedText = filled($text)
        ? (string) $text
        : (static function (int|float|string|null $bytes): ?string {
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
        })($size);

    $itemClasses = collect([
        'file-upload__item',
        'flex w-full min-w-0 items-center gap-3 rounded-md border border-zinc-200 bg-white px-3 py-2 shadow-sm',
        'dark:border-zinc-800 dark:bg-zinc-950',
        $invalid ? 'border-red-500 dark:border-red-500' : null,
    ])->filter()->implode(' ');

    $itemAttributes = $attributes
        ->except(['heading', 'text', 'size', 'invalid'])
        ->class($itemClasses)
        ->merge([
            'data-file-upload-item' => true,
        ]);

    if ($invalid) {
        $itemAttributes = $itemAttributes->merge(['data-invalid' => 'true']);
    }
@endphp

<li {{ $itemAttributes }}>
    <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
        <x-stencil::icon name="file" class="size-4" data-file-upload-item-icon />
    </span>

    <span class="flex min-w-0 flex-1 flex-col gap-0.5">
        <span
            class="truncate text-sm font-semibold text-zinc-950 dark:text-zinc-50"
            data-file-upload-item-heading
        >{{ $resolvedHeading }}</span>

        <span
            class="truncate text-sm text-zinc-500 dark:text-zinc-400"
            data-file-upload-item-text
            @if (! filled($resolvedText)) hidden @endif
        >{{ $resolvedText }}</span>
    </span>

    <span class="flex shrink-0 items-center gap-1" data-file-upload-item-actions>
        @if (isset($actions) && ! $actions->isEmpty())
            {{ $actions }}
        @else
            <x-stencil::file-upload.item.remove :disabled="$disabled" />
        @endif
    </span>
</li>
