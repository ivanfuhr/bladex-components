@php
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : 'default';
    $flyout = (bool) ($state['flyout'] ?? false);
    $alert = (bool) ($state['alert'] ?? false);
    $dismissible = (bool) ($state['dismissible'] ?? true);
    $closable = (bool) ($state['closable'] ?? true);
@endphp

<x-ui::dialog>
    <x-ui::dialog.trigger>
        <x-ui::button variant="outline"> {{ $alert ? 'Delete project' : 'Open dialog' }} </x-ui::button>
    </x-ui::dialog.trigger>

    <x-ui::dialog.content
        :size="$size"
        :flyout="$flyout"
        :alert="$alert"
        :dismissible="$dismissible"
        :closable="$closable"
    >
        <x-ui::dialog.header>
            <x-ui::dialog.title> {{ $alert ? 'Delete project?' : 'Update profile' }} </x-ui::dialog.title>
            <x-ui::dialog.description>
                @if ($alert)
                    You're about to delete this project. This action cannot be reversed.
                @else
                    Make changes to your personal details.
                @endif
            </x-ui::dialog.description>
        </x-ui::dialog.header>

        @unless ($alert)
            <div class="mt-4 space-y-3">
                <x-ui::field name="playbook_name">
                    <x-ui::field.label>Your name</x-ui::field.label>
                    <x-ui::input name="playbook_name" placeholder="Your name" />
                </x-ui::field>
            </div>
        @endunless

        <x-ui::dialog.footer>
            <x-ui::dialog.cancel>Cancel</x-ui::dialog.cancel>
            <x-ui::dialog.action :variant="$alert ? 'danger' : 'primary'">
                {{ $alert ? 'Delete project' : 'Save changes' }}
            </x-ui::dialog.action>
        </x-ui::dialog.footer>
    </x-ui::dialog.content>
</x-ui::dialog>
