@php
    $variant = ($state['variant'] ?? 'default') === 'default' ? null : $state['variant'];
@endphp

<div class="max-w-lg">
    <x-stencil::tabs default-value="account" :variant="$variant">
        <x-stencil::tabs.list>
            <x-stencil::tabs.trigger value="account">Account</x-stencil::tabs.trigger>
            <x-stencil::tabs.trigger value="password">Password</x-stencil::tabs.trigger>
            <x-stencil::tabs.trigger value="notifications">Notifications</x-stencil::tabs.trigger>
        </x-stencil::tabs.list>
        <x-stencil::tabs.content value="account">
            Manage your account settings and preferences.
        </x-stencil::tabs.content>
        <x-stencil::tabs.content value="password">
            Update your password and security options.
        </x-stencil::tabs.content>
        <x-stencil::tabs.content value="notifications">
            Choose which emails you receive.
        </x-stencil::tabs.content>
    </x-stencil::tabs>
</div>
