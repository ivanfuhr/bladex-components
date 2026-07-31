@php
    $groupClasses = collect([
        'input-otp__group',
        'flex items-center gap-2',
    ])->implode(' ');
@endphp

<div {{ $attributes->class($groupClasses)->merge(['data-input-otp-group' => true]) }}>
    {{ $slot }}
</div>
