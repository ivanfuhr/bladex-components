@extends('workbench::playbook.media.layout')

@section('title', 'Input — BladeX')

@section('content')
    <div class="space-y-10 rounded-3xl border border-zinc-200/80 bg-white p-12 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::input /&gt;</p>
            <x-bladex-components::heading :level="2">Input</x-bladex-components::heading>
            <x-bladex-components::text size="sm" variant="subtle">Affixes, prefix/suffix text, validation, and disabled states.</x-bladex-components::text>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-3">
                <x-bladex-components::text size="sm" variant="subtle">With leading &amp; trailing affixes</x-bladex-components::text>
                <x-bladex-components::input name="email" type="email" placeholder="you@example.com">
                    <x-slot:leading>
                        <x-bladex-components::icon.loading />
                    </x-slot:leading>
                    <x-slot:trailing>
                        <x-bladex-components::text inline size="sm" variant="subtle">Clear</x-bladex-components::text>
                    </x-slot:trailing>
                </x-bladex-components::input>
            </div>
            <div class="space-y-3">
                <x-bladex-components::text size="sm" variant="subtle">URL prefix &amp; suffix</x-bladex-components::text>
                <x-bladex-components::input name="site" placeholder="yoursite" prefix="https://" suffix=".com" />
            </div>
            <div class="space-y-3">
                <x-bladex-components::text size="sm" variant="subtle">Invalid</x-bladex-components::text>
                <x-bladex-components::input name="email" value="not-an-email" invalid />
            </div>
            <div class="space-y-3">
                <x-bladex-components::text size="sm" variant="subtle">Disabled &amp; readonly</x-bladex-components::text>
                <div class="grid gap-3 sm:grid-cols-2">
                    <x-bladex-components::input name="a" placeholder="Disabled" disabled />
                    <x-bladex-components::input name="b" value="Read only" readonly />
                </div>
            </div>
        </div>
    </div>
@endsection
