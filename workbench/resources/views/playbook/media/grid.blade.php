@extends('workbench::playbook.media.layout')

@section('title', 'Grid — Std Components')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-std::grid /&gt;</p>
            <x-std::heading :level="2">Grid</x-std::heading>
            <x-std::text size="sm" variant="subtle">
                Responsive columns with container-query breakpoints and span items for full-width rows.
            </x-std::text>
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

        <x-std::grid sm="2" gap="5" class="max-w-2xl">
            <x-std::field name="title">
                <x-std::field.label>Title</x-std::field.label>
                <x-std::input name="title" value="Northwind Summit" />
            </x-std::field>
            <x-std::field name="slug">
                <x-std::field.label>Slug</x-std::field.label>
                <x-std::input name="slug" value="northwind-summit" />
            </x-std::field>
            <x-std::grid.item span="full">
                <x-std::field name="summary">
                    <x-std::field.label>Summary</x-std::field.label>
                    <x-std::textarea name="summary" rows="3">Two days of product talks and workshops.</x-std::textarea>
                </x-std::field>
            </x-std::grid.item>
        </x-std::grid>
    </div>
@endsection
