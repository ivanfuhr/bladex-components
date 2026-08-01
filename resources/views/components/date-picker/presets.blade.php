@aware([
    'presetMeta' => [],
])

@props([
    'presets' => [],
    'presetMeta' => [],
])

@php
    $items = $presets !== [] ? $presets : $presetMeta;
@endphp

@if ($items !== [])
    <div class="grid sm:grid-cols-[auto_1fr]">
        <div class="hidden border-e border-zinc-200 p-2 sm:block dark:border-zinc-800" data-date-picker-presets>
            @foreach ($items as $preset)
                <x-stencil::button
                    type="button"
                    variant="ghost"
                    size="sm"
                    class="block w-full justify-start rounded-lg px-2 py-1.5 text-left text-zinc-600 dark:text-zinc-300"
                    data-date-picker-preset="{{ $preset['key'] }}"
                    data-date-picker-preset-start="{{ $preset['start'] }}"
                    data-date-picker-preset-end="{{ $preset['end'] }}"
                >
                    {{ $preset['label'] }}
                </x-stencil::button>
            @endforeach
        </div>

        <div class="min-w-0">
            {{ $slot }}
        </div>
    </div>
@else
    {{ $slot }}
@endif
