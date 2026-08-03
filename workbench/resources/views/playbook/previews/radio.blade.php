@php
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $invalid = (bool) ($state['invalid'] ?? false);
@endphp

<x-ui::field :invalid="$invalid" class="max-w-md">
    <x-ui::radio.group name="plan" legend="Billing plan">
        <x-ui::radio value="free" :size="$size">Free</x-ui::radio>
        <x-ui::radio value="pro" :size="$size" :checked="true">Pro</x-ui::radio>
        <x-ui::radio value="team" :size="$size">Team</x-ui::radio>
    </x-ui::radio.group>
</x-ui::field>
