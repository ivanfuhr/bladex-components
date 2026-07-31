@props([
    'for' => null,
    'badge' => null,
    'required' => false,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;

    $classes = collect([
        'label',
        'inline-flex items-center gap-2',
        app(FormControlClassMap::class)->labelClasses(),
    ])->implode(' ');

    $labelAttributes = $attributes
        ->class($classes)
        ->merge([
            'data-label' => true,
        ]);

    if (filled($for)) {
        $labelAttributes = $labelAttributes->merge(['for' => $for]);
    }
@endphp

<label {{ $labelAttributes }}>
    <span class="label__text">{{ $slot }}</span>

    @if ($required)
        <span class="text-red-600 dark:text-red-400" aria-hidden="true">*</span>
        <span class="sr-only">{{ __('Required') }}</span>
    @endif

    @if (filled($badge))
        <x-stencil::text
            inline
            size="sm"
            class="label__badge rounded-md border border-zinc-200 bg-zinc-50 px-1.5 py-0.5 text-xs font-medium text-zinc-600 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-400"
            data-label-badge
        >{{ $badge }}</x-stencil::text>
    @endif
</label>
