@extends('workbench::playbook.media.layout')

@section('title', 'Button variants — Stencil')

@section('content')
    <div class="space-y-8">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::button /&gt;</p>
            <x-stencil::heading :level="2">Button variants</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle"
                >Outline, primary, secondary, danger, ghost, subtle, and link.</x-stencil::text>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            @foreach (['outline', 'primary', 'secondary', 'danger', 'ghost', 'subtle', 'link'] as $variant)
                <x-stencil::button :variant="$variant"> {{ ucfirst($variant) }} </x-stencil::button>
            @endforeach
        </div>

        <div class="border-t border-zinc-200 pt-8 dark:border-zinc-800">
            <x-stencil::text size="sm" variant="subtle" class="mb-4">Sizes &amp; icon mode</x-stencil::text>
            <div class="flex flex-wrap items-end gap-3">
                <x-stencil::button variant="primary" size="xs">Extra small</x-stencil::button>
                <x-stencil::button variant="primary" size="sm">Small</x-stencil::button>
                <x-stencil::button variant="primary">Default</x-stencil::button>
                <x-stencil::button variant="primary" size="lg">Large</x-stencil::button>
                <x-stencil::button variant="outline" square>
                    <x-stencil::icon.loading />
                </x-stencil::button>
            </div>
        </div>
    </div>
@endsection
