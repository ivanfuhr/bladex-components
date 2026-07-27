@extends('workbench::playbook.media.layout')

@section('title', 'Components — BladeX')

@section('content')
    <div class="grid gap-6">
        <div class="rounded-3xl border border-zinc-200/80 bg-white p-8 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <x-bladex-components::heading :level="3" class="mb-6">Form controls</x-bladex-components::heading>
            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-3">
                    <x-bladex-components::text size="sm" variant="subtle">Input with affixes</x-bladex-components::text>
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
                    <x-bladex-components::text size="sm" variant="subtle">Custom listbox select</x-bladex-components::text>
                    <x-bladex-components::select name="industry" placeholder="Choose industry…" class="w-full">
                        <x-bladex-components::select.item value="photo">Photography</x-bladex-components::select.item>
                        <x-bladex-components::select.item value="design">Design services</x-bladex-components::select.item>
                        <x-bladex-components::select.item value="web">Web development</x-bladex-components::select.item>
                    </x-bladex-components::select>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-zinc-200/80 bg-white p-8 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <x-bladex-components::heading :level="3" class="mb-4">Typography</x-bladex-components::heading>
            <x-bladex-components::heading :level="2">Ship polished Blade UIs faster</x-bladex-components::heading>
            <x-bladex-components::text class="mt-3 max-w-prose">
                Body copy uses a shared size scale. Combine <x-bladex-components::text inline variant="strong">strong</x-bladex-components::text>,
                <x-bladex-components::text inline variant="subtle">subtle</x-bladex-components::text>, and
                <x-bladex-components::text inline color="blue">semantic colors</x-bladex-components::text> without ad-hoc classes.
            </x-bladex-components::text>
        </div>

        <div class="flex flex-wrap gap-3 rounded-3xl border border-zinc-200/80 bg-white p-8 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <x-bladex-components::button variant="outline">Cancel</x-bladex-components::button>
            <x-bladex-components::button variant="primary">Save changes</x-bladex-components::button>
        </div>
    </div>
@endsection
