@props([
    'invalid' => false,
    'size' => null,
])

@aware([
    'fieldInvalid' => false,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $isInvalid = $invalid || $fieldInvalid;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $userClass = $attributes->get('class');
    $applyFullWidth = ! filled($userClass);

    $controlClasses = collect([
        'textarea__control',
        'block min-w-0',
        $formControl->textareaSurfaceClasses($size),
        'placeholder:text-zinc-500 dark:placeholder:text-zinc-400',
        $formControl->invalidFieldClasses(),
        $isInvalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
    ])->filter()->implode(' ');

    $wrapperClasses = collect([
        'textarea',
        $applyFullWidth ? 'w-full' : null,
        $userClass,
    ])->filter()->implode(' ');

    $controlExtraClass = $attributes->get('class:textarea') ?? $attributes->get('textarea:class');

    $controlAttributes = $interactionState->apply(
        $attributes
            ->except(['class', 'class:textarea', 'textarea:class'])
            ->class([$controlClasses, $controlExtraClass])
            ->merge([
                'data-textarea-control' => true,
            ]),
    );

    if ($isInvalid) {
        $controlAttributes = $controlAttributes->merge(['aria-invalid' => 'true']);
    }
@endphp

<div @class([$wrapperClasses]) data-textarea>
    <textarea {{ $controlAttributes }}>{{ $slot }}</textarea>
</div>
