@props([
    'name' => null,
    'value' => [],
    'min' => 0,
    'max' => null,
    'sortable' => false,
    'invalid' => false,
    'disabled' => false,
    'size' => null,
])

@aware([
    'fieldInvalid' => false,
])

@php
    use Illuminate\Support\Arr;

    if (! filled($name)) {
        throw new \InvalidArgumentException('The repeater component requires a [name] attribute.');
    }

    $invalid = $invalid || $fieldInvalid;

    $normalizedValue = collect(Arr::wrap($value))
        ->map(static fn (mixed $row): array => is_array($row) ? $row : [])
        ->values()
        ->all();

    $stackKey = preg_replace('/[^a-zA-Z0-9_-]/', '-', (string) $name);
    $stackName = 'repeater-item-template-'.$stackKey;

    $rootClasses = collect([
        'repeater flex min-w-0 flex-col gap-3',
        'w-full' => ! filled($attributes->get('class')),
    ])->filter()->implode(' ');

    $rootAttributes = $attributes
        ->except(['name', 'value', 'min', 'max', 'sortable', 'invalid', 'disabled', 'size'])
        ->class($rootClasses)
        ->merge([
            'data-repeater' => true,
            'data-repeater-name' => $name,
            'data-repeater-value' => json_encode($normalizedValue, JSON_THROW_ON_ERROR),
            'data-repeater-min' => max(0, (int) $min),
        ]);

    if ($sortable) {
        $rootAttributes = $rootAttributes->merge(['data-repeater-sortable' => true]);
    }

    if ($max !== null) {
        $rootAttributes = $rootAttributes->merge([
            'data-repeater-max' => max(0, (int) $max),
        ]);
    }

    if ($disabled) {
        $rootAttributes = $rootAttributes->merge(['data-disabled' => 'true']);
    }

    if ($invalid) {
        $rootAttributes = $rootAttributes->merge([
            'data-invalid' => 'true',
            'aria-invalid' => 'true',
        ]);
    }
@endphp

<div {{ $rootAttributes }}>
    <div data-repeater-list class="repeater__list flex flex-col gap-3"></div>

    <div data-repeater-actions class="repeater__actions flex flex-col gap-3">{{ $slot }}</div>

    <template data-repeater-item-template>
        @stack($stackName)
    </template>
</div>
