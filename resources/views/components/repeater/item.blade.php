@aware([
    'name' => null,
    'disabled' => false,
    'size' => null,
    'invalid' => false,
    'fieldInvalid' => false,
])

@php
    if (! filled($name)) {
        throw new \InvalidArgumentException('The repeater.item component must be used inside a repeater with a [name] attribute.');
    }

    $stackKey = preg_replace('/[^a-zA-Z0-9_-]/', '-', (string) $name);
    $stackName = 'repeater-item-template-'.$stackKey;

    $isInvalid = $invalid || $fieldInvalid;

    $itemClasses = collect([
        'repeater__item',
        'flex flex-col gap-3 rounded-md border border-zinc-200 bg-white p-4 shadow-sm',
        'dark:border-zinc-800 dark:bg-zinc-950',
        $isInvalid ? 'border-red-500 dark:border-red-500' : null,
    ])->filter()->implode(' ');
@endphp

@push($stackName)
    <div @class([$itemClasses]) data-repeater-item>
        {{ $slot }}
    </div>
@endpush
