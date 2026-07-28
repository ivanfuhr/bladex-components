@extends('workbench::playbook.media.layout')

@section('title', 'Input — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::input /&gt;</p>
            <x-stencil::heading :level="2">Input</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Affixes, prefix/suffix text, validation, and disabled states.</x-stencil::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">With leading &amp; trailing affixes</x-stencil::text>
                <x-stencil::input name="email" type="email" placeholder="you@example.com">
                    <x-slot:leading>
                        <x-stencil::icon.loading />
                    </x-slot:leading>
                    <x-slot:trailing>
                        <x-stencil::text inline size="sm" variant="subtle">Clear</x-stencil::text>
                    </x-slot:trailing>
                </x-stencil::input>
            </div>
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">URL prefix &amp; suffix</x-stencil::text>
                <x-stencil::input name="site" placeholder="yoursite" prefix="https://" suffix=".com" />
            </div>
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Invalid</x-stencil::text>
                <x-stencil::input name="email" value="not-an-email" invalid />
            </div>
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Disabled &amp; readonly</x-stencil::text>
                <div class="grid gap-3 sm:grid-cols-2">
                    <x-stencil::input name="a" placeholder="Disabled" disabled />
                    <x-stencil::input name="b" value="Read only" readonly />
                </div>
            </div>
        </div>

        <div class="border-t border-zinc-200 pt-8 dark:border-zinc-800" data-playbook-control-alignment>
            <x-stencil::text size="sm" variant="subtle" class="mb-4">Toolbar alignment (same size in one row)</x-stencil::text>
            <div class="space-y-6">
                <div class="flex flex-wrap items-center gap-3" data-align-size="default">
                    <x-stencil::button variant="outline" data-align-part="button">Button</x-stencil::button>
                    <x-stencil::input name="align-default" placeholder="Input" class="w-36" data-align-part="input" />
                    <x-stencil::select name="align-select-default" placeholder="Select…" class="w-40" data-align-part="select">
                        <x-stencil::select.item value="a">Option A</x-stencil::select.item>
                    </x-stencil::select>
                    <x-stencil::switch name="align-switch-default" :checked="true" data-align-part="switch" />
                </div>
                <div class="flex flex-wrap items-center gap-3" data-align-size="sm">
                    <x-stencil::button variant="outline" size="sm" data-align-part="button">Button</x-stencil::button>
                    <x-stencil::input name="align-sm" size="sm" placeholder="Input" class="w-36" data-align-part="input" />
                    <x-stencil::select name="align-select-sm" size="sm" placeholder="Select…" class="w-40" data-align-part="select">
                        <x-stencil::select.item value="a">Option A</x-stencil::select.item>
                    </x-stencil::select>
                    <x-stencil::switch name="align-switch-sm" size="sm" :checked="true" data-align-part="switch" />
                </div>
            </div>
        </div>
    </div>
@endsection
