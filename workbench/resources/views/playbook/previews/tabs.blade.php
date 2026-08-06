@php
    $variant = ($state['variant'] ?? 'default') === 'default' ? null : $state['variant'];
@endphp

<div class="max-w-lg">
    <x-std::tabs default-value="account" :variant="$variant">
        <x-std::tabs.list>
            <x-std::tabs.trigger value="account">Account</x-std::tabs.trigger>
            <x-std::tabs.trigger value="password">Password</x-std::tabs.trigger>
            <x-std::tabs.trigger value="notifications">Notifications</x-std::tabs.trigger>
        </x-std::tabs.list>
        <x-std::tabs.content value="account"> Manage your account settings and preferences. </x-std::tabs.content>
        <x-std::tabs.content value="password"> Update your password and security options. </x-std::tabs.content>
        <x-std::tabs.content value="notifications"> Choose which emails you receive. </x-std::tabs.content>
    </x-std::tabs>
</div>
