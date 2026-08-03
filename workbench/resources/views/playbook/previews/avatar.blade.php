@php
    $size = ($state['size'] ?? 'default') === 'default' ? null : $state['size'];
    $color = $state['color'] ?? 'violet';
    $circle = (bool) ($state['circle'] ?? true);
    $showGroup = (bool) ($state['show_group'] ?? false);
@endphp

@if ($showGroup)
    <x-ui::avatar.group>
        <x-ui::avatar name="Ada Lovelace" :size="$size" :circle="$circle" color="violet" />
        <x-ui::avatar name="Grace Hopper" :size="$size" :circle="$circle" color="blue" />
        <x-ui::avatar name="Alan Turing" :size="$size" :circle="$circle" color="green" />
        <x-ui::avatar name="Katherine Johnson" :size="$size" :circle="$circle" color="amber" />
    </x-ui::avatar.group>
@else
    <x-ui::avatar name="Ada Lovelace" :size="$size" :circle="$circle" :color="$color" />
@endif
