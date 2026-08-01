@props([
    'invalid' => false,
    'size' => null,
    'autosize' => false,
    'counter' => false,
])

@aware([
    'fieldInvalid' => false,
    'controlId' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $isInvalid = $invalid || $fieldInvalid;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $resolvedControlId = $attributes->get('id')
        ?? $controlId
        ?? $attributes->get('name');

    $userClass = $attributes->get('class');
    $applyFullWidth = ! filled($userClass);

    $controlClasses = collect([
        'textarea__control',
        'block min-w-0',
        $formControl->textareaSurfaceClasses($size),
        'placeholder:text-zinc-500 dark:placeholder:text-zinc-400',
        $formControl->invalidFieldClasses(),
        $isInvalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
        $autosize ? 'resize-none overflow-hidden' : null,
    ])->filter()->implode(' ');

    $wrapperClasses = collect([
        'textarea',
        $applyFullWidth ? 'w-full' : null,
        $userClass,
    ])->filter()->implode(' ');

    $wrapperAttributes = $attributes
        ->except(['class', 'class:textarea', 'textarea:class', 'autosize', 'counter'])
        ->class($wrapperClasses)
        ->merge([
            'data-textarea' => true,
        ]);

    if ($autosize) {
        $wrapperAttributes = $wrapperAttributes->merge(['data-textarea-autosize' => true]);
    }

    if ($counter) {
        $wrapperAttributes = $wrapperAttributes->merge(['data-textarea-counter' => true]);
    }

    $controlExtraClass = $attributes->get('class:textarea') ?? $attributes->get('textarea:class');

    $controlAttributes = $interactionState->apply(
        $attributes
            ->except(['class', 'class:textarea', 'textarea:class', 'autosize', 'counter', 'id'])
            ->class([$controlClasses, $controlExtraClass])
            ->merge([
                'data-textarea-control' => true,
            ]),
    );

    if (filled($resolvedControlId)) {
        $controlAttributes = $controlAttributes->merge(['id' => $resolvedControlId]);
    }

    if ($isInvalid) {
        $controlAttributes = $controlAttributes->merge(['aria-invalid' => 'true']);
    }
@endphp

<div {{ $wrapperAttributes }}>
    <textarea {{ $controlAttributes }}>{{ $slot }}</textarea>
</div>

@if ($counter)
    <div
        class="textarea__counter mt-1 text-right text-xs text-zinc-500 dark:text-zinc-400"
        data-textarea-counter-display
    ></div>
@endif
