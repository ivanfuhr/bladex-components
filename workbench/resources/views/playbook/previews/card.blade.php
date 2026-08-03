@php
    $showFooter = (bool) ($state['show_footer'] ?? true);
@endphp

<div class="max-w-md">
    <x-ui::card>
        <x-ui::card.header>
            <x-ui::card.title>Account</x-ui::card.title>
            <x-ui::card.description>Manage your profile and billing preferences.</x-ui::card.description>
        </x-ui::card.header>
        <x-ui::card.content>
            <x-ui::text size="sm">
                Update your display name, email, and notification settings. Changes apply across all workspaces.
            </x-ui::text>
        </x-ui::card.content>
        @if ($showFooter)
            <x-ui::card.footer class="flex justify-end gap-2">
                <x-ui::button variant="outline">Cancel</x-ui::button>
                <x-ui::button variant="primary">Save</x-ui::button>
            </x-ui::card.footer>
        @endif
    </x-ui::card>
</div>
