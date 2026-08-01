@php
    $showIcon = (bool) ($state['show_icon'] ?? true);
    $outline = (bool) ($state['outline'] ?? false);
    $showActions = (bool) ($state['show_actions'] ?? true);
@endphp

<div class="w-full max-w-lg">
    <x-stencil::empty @class(['border border-zinc-200 dark:border-zinc-800' => $outline])>
        <x-stencil::empty.header>
            @if ($showIcon)
                <x-stencil::empty.media variant="icon" icon="file" />
            @endif
            <x-stencil::empty.title>No projects yet</x-stencil::empty.title>
            <x-stencil::empty.description>
                You haven't created any projects yet. Get started by creating your first project.
            </x-stencil::empty.description>
        </x-stencil::empty.header>
        @if ($showActions)
            <x-stencil::empty.content>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <x-stencil::button variant="primary">Create project</x-stencil::button>
                    <x-stencil::button variant="outline">Import project</x-stencil::button>
                </div>
            </x-stencil::empty.content>
        @endif
    </x-stencil::empty>
</div>
