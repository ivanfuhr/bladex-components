@php
    $showFooter = (bool) ($state['show_footer'] ?? true);
@endphp

<div class="max-w-md">
    <x-std::card>
        <x-std::card.header>
            <x-std::card.title>Account</x-std::card.title>
            <x-std::card.description>Manage your profile and billing preferences.</x-std::card.description>
        </x-std::card.header>
        <x-std::card.content>
            <x-std::text size="sm">
                Update your display name, email, and notification settings. Changes apply across all workspaces.
            </x-std::text>
        </x-std::card.content>
        @if ($showFooter)
            <x-std::card.footer class="flex justify-end gap-2">
                <x-std::button variant="outline">Cancel</x-std::button>
                <x-std::button variant="primary">Save</x-std::button>
            </x-std::card.footer>
        @endif
    </x-std::card>
</div>
