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
    </div>
@endsection
