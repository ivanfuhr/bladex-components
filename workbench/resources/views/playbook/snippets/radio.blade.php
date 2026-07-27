@php
    echo '<x-ui::radio.group name="plan" legend="Billing plan">
    <x-ui::radio value="free">Free</x-ui::radio>
    <x-ui::radio value="pro" :checked="true">Pro</x-ui::radio>
</x-ui::radio.group>';
@endphp
