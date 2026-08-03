@php
    $showIcon = (bool) ($state['show_icon'] ?? true);
    $outline = (bool) ($state['outline'] ?? false);
    $showActions = (bool) ($state['show_actions'] ?? true);
@endphp

<div class="w-full max-w-lg">
    <x-ui::empty @class(['border border-zinc-200 dark:border-zinc-800' => $outline])>
        <x-ui::empty.header>
            @if ($showIcon)
                <x-ui::empty.media variant="icon" icon="file" />
            @endif
            <x-ui::empty.title>No projects yet</x-ui::empty.title>
            <x-ui::empty.description>
                You haven't created any projects yet. Get started by creating your first project.
            </x-ui::empty.description>
        </x-ui::empty.header>
        @if ($showActions)
            <x-ui::empty.content>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <x-ui::button variant="primary">Create project</x-ui::button>
                    <x-ui::button variant="outline">Import project</x-ui::button>
                </div>
            </x-ui::empty.content>
        @endif
    </x-ui::empty>
</div>
