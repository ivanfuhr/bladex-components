@php
    $size = ($state['size'] ?? 'default') === 'default' ? null : $state['size'];
    $color = $state['color'] ?? 'violet';
    $circle = (bool) ($state['circle'] ?? true);
    $showGroup = (bool) ($state['show_group'] ?? false);
@endphp

@if ($showGroup)
    <x-stencil::avatar.group>
        <x-stencil::avatar name="Ada Lovelace" :size="$size" :circle="$circle" color="violet" />
        <x-stencil::avatar name="Grace Hopper" :size="$size" :circle="$circle" color="blue" />
        <x-stencil::avatar name="Alan Turing" :size="$size" :circle="$circle" color="green" />
        <x-stencil::avatar name="Katherine Johnson" :size="$size" :circle="$circle" color="amber" />
    </x-stencil::avatar.group>
@else
    <x-stencil::avatar name="Ada Lovelace" :size="$size" :circle="$circle" :color="$color" />
@endif
