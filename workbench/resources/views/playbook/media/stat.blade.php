@extends('workbench::playbook.media.layout')

@section('title', 'Stat — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::stat /&gt;</p>
            <x-ui::heading :level="2">Stat</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">Compact KPI cards for admin dashboards.</x-ui::text>
        </div>

        <div class="grid max-w-3xl gap-4 sm:grid-cols-3">
            <x-ui::stat
                label="Open tickets"
                value="128"
                trend="+12.4%"
                trend-direction="up"
                description="vs last 7 days"
                icon="file"
            />
            <x-ui::stat
                label="Avg. response"
                value="2.4h"
                trend="−18m"
                trend-direction="up"
                description="First reply time"
                icon="clock"
            />
            <x-ui::stat variant="muted" label="Resolved" value="86%" description="This week" />
        </div>
    </div>
@endsection
