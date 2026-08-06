@php
    $indeterminate = (bool) ($state['indeterminate'] ?? false);
    $value = (int) ($state['value'] ?? 40);
    $size = ($state['size'] ?? 'default') === 'default' ? null : $state['size'];
@endphp

<div class="max-w-md space-y-2">
    <x-std::progress :value="$value" :size="$size" :indeterminate="$indeterminate" />
</div>
