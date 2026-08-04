@extends('workbench::playbook.media.layout')

@section('title', 'Grid — Stencil')

@section('content')
    <div class="space-y-10">
        <div class="space-y-1">
            <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">&lt;x-ui::grid /&gt;</p>
            <x-ui::heading :level="2">Grid</x-ui::heading>
            <x-ui::text size="sm" variant="subtle">
                Responsive columns with container-query breakpoints and span items for full-width rows.
            </x-ui::text>
        </div>

        <x-ui::grid md="3" gap="4" class="max-w-3xl">
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
        </x-ui::grid>

        <x-ui::grid sm="2" gap="5" class="max-w-2xl">
            <x-ui::field name="title">
                <x-ui::field.label>Title</x-ui::field.label>
                <x-ui::input name="title" value="Northwind Summit" />
            </x-ui::field>
            <x-ui::field name="slug">
                <x-ui::field.label>Slug</x-ui::field.label>
                <x-ui::input name="slug" value="northwind-summit" />
            </x-ui::field>
            <x-ui::grid.item span="full">
                <x-ui::field name="summary">
                    <x-ui::field.label>Summary</x-ui::field.label>
                    <x-ui::textarea name="summary" rows="3">Two days of product talks and workshops.</x-ui::textarea>
                </x-ui::field>
            </x-ui::grid.item>
        </x-ui::grid>
    </div>
@endsection
