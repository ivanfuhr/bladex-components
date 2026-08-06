@php
    $size = ($state['size'] ?? 'default') === 'default' ? null : $state['size'];
    $color = $state['color'] ?? 'violet';
    $circle = (bool) ($state['circle'] ?? true);
    $showGroup = (bool) ($state['show_group'] ?? false);
@endphp

@if ($showGroup)
    <x-std::avatar.group>
        <x-std::avatar name="Ada Lovelace" :size="$size" :circle="$circle" color="violet" />
        <x-std::avatar name="Grace Hopper" :size="$size" :circle="$circle" color="blue" />
        <x-std::avatar name="Alan Turing" :size="$size" :circle="$circle" color="green" />
        <x-std::avatar name="Katherine Johnson" :size="$size" :circle="$circle" color="amber" />
    </x-std::avatar.group>
@else
    <x-std::avatar name="Ada Lovelace" :size="$size" :circle="$circle" :color="$color" />
@endif
