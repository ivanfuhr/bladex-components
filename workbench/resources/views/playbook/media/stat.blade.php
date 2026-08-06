@extends('workbench::playbook.media.layout')

@section('title', 'Stat — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::stat /&gt;</p>
            <x-std::heading :level="2">Stat</x-std::heading>
            <x-std::text size="sm" variant="subtle">Compact KPI cards for admin dashboards.</x-std::text>
        </div>

        <x-std::grid md="3" gap="4" class="max-w-3xl">
            <x-std::stat
                label="Open tickets"
                value="128"
                trend="+12.4%"
                trend-direction="up"
                description="vs last 7 days"
                icon="file"
            />
            <x-std::stat
                label="Avg. response"
                value="2.4h"
                trend="−18m"
                trend-direction="up"
                description="First reply time"
                icon="clock"
            />
            <x-std::stat variant="muted" label="Resolved" value="86%" description="This week" />
        </x-std::grid>
    </div>
@endsection
