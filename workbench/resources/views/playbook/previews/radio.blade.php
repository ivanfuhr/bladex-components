@php
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $invalid = (bool) ($state['invalid'] ?? false);
@endphp

<x-stencil::field :invalid="$invalid" class="max-w-md">
    <x-stencil::radio.group name="plan" legend="Billing plan">
        <x-stencil::radio value="free" :size="$size">Free</x-stencil::radio>
        <x-stencil::radio value="pro" :size="$size" :checked="true">Pro</x-stencil::radio>
        <x-stencil::radio value="team" :size="$size">Team</x-stencil::radio>
    </x-stencil::radio.group>
</x-stencil::field>
