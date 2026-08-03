@extends('workbench::playbook.media.layout')

@section('title', 'Tabs — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::tabs /&gt;</p>
            <x-ui::heading :level="2">Tabs</x-ui::heading>
            <x-ui::text size="sm" variant="subtle"
                >Tabbed panels with default, segmented, pills, and line variants.</x-ui::text>
        </div>

        <div class="grid gap-10 lg:grid-cols-2">
            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Default</x-ui::text>
                <x-ui::tabs default-value="account">
                    <x-ui::tabs.list>
                        <x-ui::tabs.trigger value="account">Account</x-ui::tabs.trigger>
                        <x-ui::tabs.trigger value="password">Password</x-ui::tabs.trigger>
                    </x-ui::tabs.list>
                    <x-ui::tabs.content value="account">
                        Manage your account settings and preferences.</x-ui::tabs.content>
                    <x-ui::tabs.content value="password">
                        Update your password and security options.</x-ui::tabs.content>
                </x-ui::tabs>
            </div>

            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Line</x-ui::text>
                <x-ui::tabs default-value="overview" variant="line">
                    <x-ui::tabs.list>
                        <x-ui::tabs.trigger value="overview">Overview</x-ui::tabs.trigger>
                        <x-ui::tabs.trigger value="analytics">Analytics</x-ui::tabs.trigger>
                        <x-ui::tabs.trigger value="reports">Reports</x-ui::tabs.trigger>
                    </x-ui::tabs.list>
                    <x-ui::tabs.content value="overview"> Project overview and recent activity.</x-ui::tabs.content>
                    <x-ui::tabs.content value="analytics">Traffic and conversion metrics.</x-ui::tabs.content>
                    <x-ui::tabs.content value="reports">Exportable weekly reports.</x-ui::tabs.content>
                </x-ui::tabs>
            </div>

            <div class="space-y-3">
                <x-ui::text size="sm" variant="subtle">Pills</x-ui::text>
                <x-ui::tabs default-value="all" variant="pills">
                    <x-ui::tabs.list>
                        <x-ui::tabs.trigger value="all">All</x-ui::tabs.trigger>
                        <x-ui::tabs.trigger value="active">Active</x-ui::tabs.trigger>
                        <x-ui::tabs.trigger value="archived">Archived</x-ui::tabs.trigger>
                    </x-ui::tabs.list>
                    <x-ui::tabs.content value="all">Showing every item in the collection.</x-ui::tabs.content>
                    <x-ui::tabs.content value="active">Only active items.</x-ui::tabs.content>
                    <x-ui::tabs.content value="archived">Archived items.</x-ui::tabs.content>
                </x-ui::tabs>
            </div>
        </div>
    </div>
@endsection
