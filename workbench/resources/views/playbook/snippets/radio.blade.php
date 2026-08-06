@php
    echo '<x-std::radio.group name="plan" legend="Billing plan">
        <x-std::radio value="free">Free</x-std::radio>
        <x-std::radio value="pro" :checked="true">Pro</x-std::radio>
    </x-std::radio.group>';
@endphp
