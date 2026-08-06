@extends('workbench::playbook.media.layout')

@section('title', 'Button variants — Std Components')

@section('content')
    <div class="space-y-8">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::button /&gt;</p>
            <x-std::heading :level="2">Button variants</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Outline, primary, secondary, danger, ghost, subtle, and link.</x-std::text>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            @foreach (['outline', 'primary', 'secondary', 'danger', 'ghost', 'subtle', 'link'] as $variant)
                <x-std::button :variant="$variant"> {{ ucfirst($variant) }} </x-std::button>
            @endforeach
        </div>

        <div class="border-t border-zinc-200 pt-8 dark:border-zinc-800">
            <x-std::text size="sm" variant="subtle" class="mb-4">Sizes &amp; icon mode</x-std::text>
            <div class="flex flex-wrap items-end gap-3">
                <x-std::button variant="primary" size="xs">Extra small</x-std::button>
                <x-std::button variant="primary" size="sm">Small</x-std::button>
                <x-std::button variant="primary">Default</x-std::button>
                <x-std::button variant="primary" size="lg">Large</x-std::button>
                <x-std::button variant="outline" square>
                    <x-std::icon.loading />
                </x-std::button>
            </div>
        </div>
    </div>
@endsection
