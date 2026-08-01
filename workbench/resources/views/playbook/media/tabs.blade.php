@extends('workbench::playbook.media.layout')

@section('title', 'Tabs — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::tabs /&gt;</p>
            <x-stencil::heading :level="2">Tabs</x-stencil::heading>
            <x-stencil::text size="sm" variant="subtle">Tabbed panels with default, segmented, pills, and line variants.</x-stencil::text>
        </div>

        <div class="grid gap-10 lg:grid-cols-2">
            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Default</x-stencil::text>
                <x-stencil::tabs default-value="account">
                    <x-stencil::tabs.list>
                        <x-stencil::tabs.trigger value="account">Account</x-stencil::tabs.trigger>
                        <x-stencil::tabs.trigger value="password">Password</x-stencil::tabs.trigger>
                    </x-stencil::tabs.list>
                    <x-stencil::tabs.content value="account">Manage your account settings and preferences.</x-stencil::tabs.content>
                    <x-stencil::tabs.content value="password">Update your password and security options.</x-stencil::tabs.content>
                </x-stencil::tabs>
            </div>

            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Line</x-stencil::text>
                <x-stencil::tabs default-value="overview" variant="line">
                    <x-stencil::tabs.list>
                        <x-stencil::tabs.trigger value="overview">Overview</x-stencil::tabs.trigger>
                        <x-stencil::tabs.trigger value="analytics">Analytics</x-stencil::tabs.trigger>
                        <x-stencil::tabs.trigger value="reports">Reports</x-stencil::tabs.trigger>
                    </x-stencil::tabs.list>
                    <x-stencil::tabs.content value="overview">Project overview and recent activity.</x-stencil::tabs.content>
                    <x-stencil::tabs.content value="analytics">Traffic and conversion metrics.</x-stencil::tabs.content>
                    <x-stencil::tabs.content value="reports">Exportable weekly reports.</x-stencil::tabs.content>
                </x-stencil::tabs>
            </div>

            <div class="space-y-3">
                <x-stencil::text size="sm" variant="subtle">Pills</x-stencil::text>
                <x-stencil::tabs default-value="all" variant="pills">
                    <x-stencil::tabs.list>
                        <x-stencil::tabs.trigger value="all">All</x-stencil::tabs.trigger>
                        <x-stencil::tabs.trigger value="active">Active</x-stencil::tabs.trigger>
                        <x-stencil::tabs.trigger value="archived">Archived</x-stencil::tabs.trigger>
                    </x-stencil::tabs.list>
                    <x-stencil::tabs.content value="all">Showing every item in the collection.</x-stencil::tabs.content>
                    <x-stencil::tabs.content value="active">Only active items.</x-stencil::tabs.content>
                    <x-stencil::tabs.content value="archived">Archived items.</x-stencil::tabs.content>
                </x-stencil::tabs>
            </div>
        </div>
    </div>
@endsection
