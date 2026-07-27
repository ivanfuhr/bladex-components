@extends('workbench::playbook.media.layout')

@section('title', 'Button variants — BladeX')

@section('content')
    <div class="space-y-8 rounded-3xl border border-zinc-200/80 bg-white p-10 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::button /&gt;</p>
            <x-bladex-components::heading :level="2">Button variants</x-bladex-components::heading>
            <x-bladex-components::text size="sm" variant="subtle">Outline, primary, secondary, danger, ghost, subtle, and link.</x-bladex-components::text>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            @foreach (['outline', 'primary', 'secondary', 'danger', 'ghost', 'subtle', 'link'] as $variant)
                <x-bladex-components::button :variant="$variant">
                    {{ ucfirst($variant) }}
                </x-bladex-components::button>
            @endforeach
        </div>

        <div class="border-t border-zinc-200 pt-8 dark:border-zinc-800">
            <x-bladex-components::text size="sm" variant="subtle" class="mb-4">Sizes &amp; icon mode</x-bladex-components::text>
            <div class="flex flex-wrap items-end gap-3">
                <x-bladex-components::button variant="primary" size="xs">Extra small</x-bladex-components::button>
                <x-bladex-components::button variant="primary" size="sm">Small</x-bladex-components::button>
                <x-bladex-components::button variant="primary">Default</x-bladex-components::button>
                <x-bladex-components::button variant="primary" size="lg">Large</x-bladex-components::button>
                <x-bladex-components::button variant="outline" square>
                    <x-bladex-components::icon.loading />
                </x-bladex-components::button>
            </div>
        </div>
    </div>
@endsection
