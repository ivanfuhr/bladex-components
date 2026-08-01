@php
    $showFooter = (bool) ($state['show_footer'] ?? true);
@endphp

<div class="max-w-md">
    <x-stencil::card>
        <x-stencil::card.header>
            <x-stencil::card.title>Account</x-stencil::card.title>
            <x-stencil::card.description>Manage your profile and billing preferences.</x-stencil::card.description>
        </x-stencil::card.header>
        <x-stencil::card.content>
            <x-stencil::text size="sm">
                Update your display name, email, and notification settings. Changes apply across all workspaces.
            </x-stencil::text>
        </x-stencil::card.content>
        @if ($showFooter)
            <x-stencil::card.footer class="flex justify-end gap-2">
                <x-stencil::button variant="outline">Cancel</x-stencil::button>
                <x-stencil::button variant="primary">Save</x-stencil::button>
            </x-stencil::card.footer>
        @endif
    </x-stencil::card>
</div>
