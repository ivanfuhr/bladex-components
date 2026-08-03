@extends('workbench::playbook.media.layout')

@section('title', 'Button variants — Stencil')

@section('content')
    <div class="space-y-8">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::button /&gt;</p>
            <x-ui::heading :level="2">Button variants</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Outline, primary, secondary, danger, ghost, subtle, and link.</x-ui::text>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            @foreach (['outline', 'primary', 'secondary', 'danger', 'ghost', 'subtle', 'link'] as $variant)
                <x-ui::button :variant="$variant"> {{ ucfirst($variant) }} </x-ui::button>
            @endforeach
        </div>

        <div class="border-t border-zinc-200 pt-8 dark:border-zinc-800">
            <x-ui::text size="sm" variant="subtle" class="mb-4">Sizes &amp; icon mode</x-ui::text>
            <div class="flex flex-wrap items-end gap-3">
                <x-ui::button variant="primary" size="xs">Extra small</x-ui::button>
                <x-ui::button variant="primary" size="sm">Small</x-ui::button>
                <x-ui::button variant="primary">Default</x-ui::button>
                <x-ui::button variant="primary" size="lg">Large</x-ui::button>
                <x-ui::button variant="outline" square>
                    <x-ui::icon.loading />
                </x-ui::button>
            </div>
        </div>
    </div>
@endsection
