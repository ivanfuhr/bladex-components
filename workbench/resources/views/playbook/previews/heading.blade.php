@php
    $level = (int) $state['level'];
    $variant = $state['variant'] === 'default' ? null : $state['variant'];
@endphp

<x-stencil::heading :level="$level" :variant="$variant">
    Page title at level {{ $level }}
</x-stencil::heading>
