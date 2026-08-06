@php
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : 'default';
    $flyout = (bool) ($state['flyout'] ?? false);
    $alert = (bool) ($state['alert'] ?? false);
    $dismissible = (bool) ($state['dismissible'] ?? true);
    $closable = (bool) ($state['closable'] ?? true);
@endphp

<x-std::dialog>
    <x-std::dialog.trigger>
        <x-std::button variant="outline"> {{ $alert ? 'Delete project' : 'Open dialog' }} </x-std::button>
    </x-std::dialog.trigger>

    <x-std::dialog.content
        :size="$size"
        :flyout="$flyout"
        :alert="$alert"
        :dismissible="$dismissible"
        :closable="$closable"
    >
        <x-std::dialog.header>
            <x-std::dialog.title> {{ $alert ? 'Delete project?' : 'Update profile' }} </x-std::dialog.title>
            <x-std::dialog.description>
                @if ($alert)
                    You're about to delete this project. This action cannot be reversed.
                @else
                    Make changes to your personal details.
                @endif
            </x-std::dialog.description>
        </x-std::dialog.header>

        @unless ($alert)
            <div class="mt-4 space-y-3">
                <x-std::field name="playbook_name">
                    <x-std::field.label>Your name</x-std::field.label>
                    <x-std::input name="playbook_name" placeholder="Your name" />
                </x-std::field>
            </div>
        @endunless

        <x-std::dialog.footer>
            <x-std::dialog.cancel>Cancel</x-std::dialog.cancel>
            <x-std::dialog.action :variant="$alert ? 'danger' : 'primary'">
                {{ $alert ? 'Delete project' : 'Save changes' }}
            </x-std::dialog.action>
        </x-std::dialog.footer>
    </x-std::dialog.content>
</x-std::dialog>
