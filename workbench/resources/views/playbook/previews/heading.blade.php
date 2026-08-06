@php
    $level = (int) $state['level'];
    $variant = $state['variant'] === 'default' ? null : $state['variant'];
@endphp

<x-std::heading :level="$level" :variant="$variant"> Page title at level {{ $level }} </x-std::heading>
