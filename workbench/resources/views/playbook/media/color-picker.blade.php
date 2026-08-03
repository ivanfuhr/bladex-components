@extends('workbench::playbook.media.layout')

@section('title', 'Color Picker — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::color-picker /&gt;</p>
            <x-ui::heading :level="2">Color Picker</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Popover with saturation canvas, hue slider, and Tailwind swatches.</x-ui::text>
        </div>

        <div class="relative mx-auto min-h-[28rem] w-full max-w-xs">
            <x-ui::color-picker name="brand_color" value="#3366cc" class="w-full" />
        </div>
    </div>
@endsection
