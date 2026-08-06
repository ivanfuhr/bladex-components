@php
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $invalid = (bool) ($state['invalid'] ?? false);
@endphp

<x-std::field :invalid="$invalid" class="max-w-md">
    <x-std::radio.group name="plan" legend="Billing plan">
        <x-std::radio value="free" :size="$size">Free</x-std::radio>
        <x-std::radio value="pro" :size="$size" :checked="true">Pro</x-std::radio>
        <x-std::radio value="team" :size="$size">Team</x-std::radio>
    </x-std::radio.group>
</x-std::field>
