@php
    $variant = ($state['variant'] ?? 'default') === 'default' ? null : $state['variant'];
@endphp

<div class="max-w-lg">
    <x-ui::tabs default-value="account" :variant="$variant">
        <x-ui::tabs.list>
            <x-ui::tabs.trigger value="account">Account</x-ui::tabs.trigger>
            <x-ui::tabs.trigger value="password">Password</x-ui::tabs.trigger>
            <x-ui::tabs.trigger value="notifications">Notifications</x-ui::tabs.trigger>
        </x-ui::tabs.list>
        <x-ui::tabs.content value="account"> Manage your account settings and preferences. </x-ui::tabs.content>
        <x-ui::tabs.content value="password"> Update your password and security options. </x-ui::tabs.content>
        <x-ui::tabs.content value="notifications"> Choose which emails you receive. </x-ui::tabs.content>
    </x-ui::tabs>
</div>
