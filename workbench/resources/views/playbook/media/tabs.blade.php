@extends('workbench::playbook.media.layout')

@section('title', 'Tabs — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::tabs /&gt;</p>
            <x-std::heading :level="2">Tabs</x-std::heading>
            <x-std::text size="sm" variant="subtle"
                >Tabbed panels with default, segmented, pills, and line variants.</x-std::text>
        </div>

        <div class="grid gap-10 lg:grid-cols-2">
            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Default</x-std::text>
                <x-std::tabs default-value="account">
                    <x-std::tabs.list>
                        <x-std::tabs.trigger value="account">Account</x-std::tabs.trigger>
                        <x-std::tabs.trigger value="password">Password</x-std::tabs.trigger>
                    </x-std::tabs.list>
                    <x-std::tabs.content value="account">
                        Manage your account settings and preferences.</x-std::tabs.content>
                    <x-std::tabs.content value="password">
                        Update your password and security options.</x-std::tabs.content>
                </x-std::tabs>
            </div>

            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Line</x-std::text>
                <x-std::tabs default-value="overview" variant="line">
                    <x-std::tabs.list>
                        <x-std::tabs.trigger value="overview">Overview</x-std::tabs.trigger>
                        <x-std::tabs.trigger value="analytics">Analytics</x-std::tabs.trigger>
                        <x-std::tabs.trigger value="reports">Reports</x-std::tabs.trigger>
                    </x-std::tabs.list>
                    <x-std::tabs.content value="overview"> Project overview and recent activity.</x-std::tabs.content>
                    <x-std::tabs.content value="analytics">Traffic and conversion metrics.</x-std::tabs.content>
                    <x-std::tabs.content value="reports">Exportable weekly reports.</x-std::tabs.content>
                </x-std::tabs>
            </div>

            <div class="space-y-3">
                <x-std::text size="sm" variant="subtle">Pills</x-std::text>
                <x-std::tabs default-value="all" variant="pills">
                    <x-std::tabs.list>
                        <x-std::tabs.trigger value="all">All</x-std::tabs.trigger>
                        <x-std::tabs.trigger value="active">Active</x-std::tabs.trigger>
                        <x-std::tabs.trigger value="archived">Archived</x-std::tabs.trigger>
                    </x-std::tabs.list>
                    <x-std::tabs.content value="all">Showing every item in the collection.</x-std::tabs.content>
                    <x-std::tabs.content value="active">Only active items.</x-std::tabs.content>
                    <x-std::tabs.content value="archived">Archived items.</x-std::tabs.content>
                </x-std::tabs>
            </div>
        </div>
    </div>
@endsection
