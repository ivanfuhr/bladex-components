@php
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : 'default';
    $flyout = (bool) ($state['flyout'] ?? false);
    $alert = (bool) ($state['alert'] ?? false);
    $dismissible = (bool) ($state['dismissible'] ?? true);
    $closable = (bool) ($state['closable'] ?? true);
@endphp

<x-stencil::dialog>
    <x-stencil::dialog.trigger>
        <x-stencil::button variant="outline">
            {{ $alert ? 'Delete project' : 'Open dialog' }}
        </x-stencil::button>
    </x-stencil::dialog.trigger>

    <x-stencil::dialog.content
        :size="$size"
        :flyout="$flyout"
        :alert="$alert"
        :dismissible="$dismissible"
        :closable="$closable"
    >
        <x-stencil::dialog.header>
            <x-stencil::dialog.title>
                {{ $alert ? 'Delete project?' : 'Update profile' }}
            </x-stencil::dialog.title>
            <x-stencil::dialog.description>
                @if ($alert)
                    You're about to delete this project. This action cannot be reversed.
                @else
                    Make changes to your personal details.
                @endif
            </x-stencil::dialog.description>
        </x-stencil::dialog.header>

        @unless ($alert)
            <div class="mt-4 space-y-3">
                <x-stencil::field name="playbook_name">
                    <x-stencil::field.label>Your name</x-stencil::field.label>
                    <x-stencil::input name="playbook_name" placeholder="Your name" />
                </x-stencil::field>
            </div>
        @endunless

        <x-stencil::dialog.footer>
            <x-stencil::dialog.cancel>Cancel</x-stencil::dialog.cancel>
            <x-stencil::dialog.action :variant="$alert ? 'danger' : 'primary'">
                {{ $alert ? 'Delete project' : 'Save changes' }}
            </x-stencil::dialog.action>
        </x-stencil::dialog.footer>
    </x-stencil::dialog.content>
</x-stencil::dialog>
