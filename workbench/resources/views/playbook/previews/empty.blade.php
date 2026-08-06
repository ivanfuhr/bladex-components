@php
    $showIcon = (bool) ($state['show_icon'] ?? true);
    $outline = (bool) ($state['outline'] ?? false);
    $showActions = (bool) ($state['show_actions'] ?? true);
@endphp

<div class="w-full max-w-lg">
    <x-std::empty @class(['border border-zinc-200 dark:border-zinc-800' => $outline])>
        <x-std::empty.header>
            @if ($showIcon)
                <x-std::empty.media variant="icon" icon="file" />
            @endif
            <x-std::empty.title>No projects yet</x-std::empty.title>
            <x-std::empty.description>
                You haven't created any projects yet. Get started by creating your first project.
            </x-std::empty.description>
        </x-std::empty.header>
        @if ($showActions)
            <x-std::empty.content>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <x-std::button variant="primary">Create project</x-std::button>
                    <x-std::button variant="outline">Import project</x-std::button>
                </div>
            </x-std::empty.content>
        @endif
    </x-std::empty>
</div>
