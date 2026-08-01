{{--
THESIS: One real Event Studio screen that composes every Stencil primitive in situ — not a prop zoo.
OWN-WORLD: Playbook zinc surfaces, restrained neutrals, Operate density; components carry the craft.
STORY: Organizer finishes Northwind Summit setup — edit details, schedule, guests, then publish.
FIRST VIEWPORT: Breadcrumb + event title + status badges + team avatars + actions; alert + progress; tabbed workspace.
FORM: Established playbook surface extension (Operate); seed n/a.
--}}
@extends('workbench::layouts.playbook')

@section('title', 'Showcase — Event Studio')

@section('content')
    <x-stencil::toast.provider position="bottom-right">
        <x-stencil::toast
            variant="success"
            title="Draft autosaved"
            description="Northwind Summit was saved a moment ago."
            :duration="8000"
        />
    </x-stencil::toast.provider>

    <div class="space-y-8">
        {{-- Wayfinding --}}
        <x-stencil::breadcrumb>
            <x-stencil::breadcrumb.list>
                <x-stencil::breadcrumb.item :href="route('playbook.index')">Playbook</x-stencil::breadcrumb.item>
                <x-stencil::breadcrumb.separator />
                <x-stencil::breadcrumb.item :href="route('playbook.showcase')">Showcase</x-stencil::breadcrumb.item>
                <x-stencil::breadcrumb.separator />
                <x-stencil::breadcrumb.item>
                    <x-stencil::breadcrumb.page>Northwind Summit</x-stencil::breadcrumb.page>
                </x-stencil::breadcrumb.item>
            </x-stencil::breadcrumb.list>
        </x-stencil::breadcrumb>

        {{-- Page header --}}
        <header class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div class="min-w-0 space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                    <x-stencil::heading :level="1">Northwind Summit 2026</x-stencil::heading>
                    <x-stencil::badge color="amber" rounded>Draft</x-stencil::badge>
                    <x-stencil::badge variant="outline" rounded>Public page</x-stencil::badge>
                </div>
                <x-stencil::text variant="subtle" class="max-w-prose">
                    Real-world composition of Stencil components — an event editor an organizer would actually use.
                    Illustrative data only.
                </x-stencil::text>
                <div class="flex flex-wrap items-center gap-3 pt-1">
                    <x-stencil::avatar.group>
                        <x-stencil::avatar name="Ada Lovelace" circle color="violet" />
                        <x-stencil::avatar name="Grace Hopper" circle color="blue" />
                        <x-stencil::avatar name="Alan Turing" circle color="green" />
                    </x-stencil::avatar.group>
                    <x-stencil::text size="sm" variant="subtle">3 organizers</x-stencil::text>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <x-stencil::tooltip side="bottom">
                    <x-stencil::tooltip.trigger>
                        <x-stencil::button variant="outline" square aria-label="Preview public page">
                            <x-stencil::icon name="eye" class="size-4" />
                        </x-stencil::button>
                    </x-stencil::tooltip.trigger>
                    <x-stencil::tooltip.content>Preview public page</x-stencil::tooltip.content>
                </x-stencil::tooltip>

                <x-stencil::dropdown-menu align="end">
                    <x-stencil::dropdown-menu.trigger>
                        <x-stencil::button variant="outline">
                            More
                            <x-stencil::icon name="chevron-down" class="size-4 opacity-60" />
                        </x-stencil::button>
                    </x-stencil::dropdown-menu.trigger>
                    <x-stencil::dropdown-menu.content>
                        <x-stencil::dropdown-menu.label>Event</x-stencil::dropdown-menu.label>
                        <x-stencil::dropdown-menu.item>
                            Duplicate
                            <x-stencil::dropdown-menu.shortcut>⌘D</x-stencil::dropdown-menu.shortcut>
                        </x-stencil::dropdown-menu.item>
                        <x-stencil::dropdown-menu.item>
                            Export CSV
                            <x-stencil::dropdown-menu.shortcut>⌘E</x-stencil::dropdown-menu.shortcut>
                        </x-stencil::dropdown-menu.item>
                        <x-stencil::dropdown-menu.separator />
                        <x-stencil::dropdown-menu.item variant="danger"> Archive event </x-stencil::dropdown-menu.item>
                    </x-stencil::dropdown-menu.content>
                </x-stencil::dropdown-menu>

                <x-stencil::dialog>
                    <x-stencil::dialog.trigger>
                        <x-stencil::button variant="primary">Publish event</x-stencil::button>
                    </x-stencil::dialog.trigger>
                    <x-stencil::dialog.content>
                        <x-stencil::dialog.header>
                            <x-stencil::dialog.title>Publish Northwind Summit?</x-stencil::dialog.title>
                            <x-stencil::dialog.description>
                                The public page goes live and ticket sales open immediately.
                            </x-stencil::dialog.description>
                        </x-stencil::dialog.header>
                        <div class="mt-4 space-y-3">
                            <x-stencil::field name="publish_note">
                                <x-stencil::field.label>Release note</x-stencil::field.label>
                                <x-stencil::input name="publish_note" placeholder="What changed for attendees?" />
                                <x-stencil::field.description>
                                    Shown once in the organizer activity feed.</x-stencil::field.description>
                            </x-stencil::field>
                        </div>
                        <x-stencil::dialog.footer>
                            <x-stencil::dialog.cancel>Keep drafting</x-stencil::dialog.cancel>
                            <x-stencil::dialog.action variant="primary">Publish now</x-stencil::dialog.action>
                        </x-stencil::dialog.footer>
                    </x-stencil::dialog.content>
                </x-stencil::dialog>
            </div>
        </header>

        {{-- Status strip --}}
        <div class="space-y-3">
            <x-stencil::alert variant="warning" title="Finish setup before publishing" icon="clipboard">
                <x-stencil::alert.description>
                    Add at least one ticket tier and confirm the venue capacity. Your public page stays gated until
                    then.
                </x-stencil::alert.description>
            </x-stencil::alert>
            <div class="space-y-2">
                <div class="flex items-center justify-between gap-3">
                    <x-stencil::text size="sm" variant="subtle">Setup progress</x-stencil::text>
                    <x-stencil::text size="sm" class="font-medium tabular-nums">72%</x-stencil::text>
                </div>
                <x-stencil::progress :value="72" />
            </div>
        </div>

        <x-stencil::separator />

        {{-- Main workspace --}}
        <form action="#" method="post" class="space-y-6" onsubmit="return false;">
            @csrf

            <x-stencil::tabs default-value="details" variant="line">
                <x-stencil::tabs.list class="border-b border-zinc-200 dark:border-zinc-800">
                    <x-stencil::tabs.trigger value="details">Details</x-stencil::tabs.trigger>
                    <x-stencil::tabs.trigger value="schedule">Schedule</x-stencil::tabs.trigger>
                    <x-stencil::tabs.trigger value="guests">Guests</x-stencil::tabs.trigger>
                    <x-stencil::tabs.trigger value="settings">Settings</x-stencil::tabs.trigger>
                </x-stencil::tabs.list>

                {{-- Details --}}
                <x-stencil::tabs.content value="details" class="mt-6!">
                    <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_18rem]">
                        <div class="space-y-6">
                            <x-stencil::card>
                                <x-stencil::card.header>
                                    <x-stencil::card.title>Event profile</x-stencil::card.title>
                                    <x-stencil::card.description>
                                        Basics shown on the public landing page and tickets.
                                    </x-stencil::card.description>
                                </x-stencil::card.header>
                                <x-stencil::card.content class="space-y-5">
                                    <x-stencil::field name="title">
                                        <x-stencil::field.label :required="true">Title</x-stencil::field.label>
                                        <x-stencil::input name="title" value="Northwind Summit 2026" />
                                    </x-stencil::field>

                                    <x-stencil::field name="slug">
                                        <x-stencil::label for="slug">Public URL</x-stencil::label>
                                        <x-stencil::input
                                            id="slug"
                                            name="slug"
                                            prefix="https://"
                                            suffix=".events.test"
                                            value="northwind-summit"
                                        />
                                        <x-stencil::field.description>
                                            Lowercase letters, numbers, and hyphens.</x-stencil::field.description>
                                    </x-stencil::field>

                                    <x-stencil::field name="summary">
                                        <x-stencil::field.label>Summary</x-stencil::field.label>
                                        <x-stencil::textarea
                                            name="summary"
                                            rows="3"
                                            placeholder="One short paragraph for search results and invites…"
                                            >Two days of talks, workshops, and hallway track for Laravel teams shipping
                                            Blade UIs.</x-stencil::textarea>
                                    </x-stencil::field>

                                    <div class="grid gap-5 sm:grid-cols-2">
                                        <x-stencil::field name="format">
                                            <x-stencil::field.label>Format</x-stencil::field.label>
                                            <x-stencil::select name="format" placeholder="Choose format…">
                                                <x-stencil::select.group>
                                                    <x-stencil::select.label>In person</x-stencil::select.label>
                                                    <x-stencil::select.item value="conference">
                                                        Conference</x-stencil::select.item>
                                                    <x-stencil::select.item value="workshop">
                                                        Workshop</x-stencil::select.item>
                                                </x-stencil::select.group>
                                                <x-stencil::select.separator />
                                                <x-stencil::select.item value="hybrid">Hybrid</x-stencil::select.item>
                                                <x-stencil::select.item value="online">
                                                    Online only</x-stencil::select.item>
                                            </x-stencil::select>
                                        </x-stencil::field>

                                        <x-stencil::field name="venue_city">
                                            <x-stencil::field.label>City</x-stencil::field.label>
                                            <x-stencil::combobox
                                                name="venue_city"
                                                placeholder="Search cities…"
                                                value="porto-alegre"
                                            >
                                                <x-stencil::combobox.group>
                                                    <x-stencil::combobox.label>Brazil</x-stencil::combobox.label>
                                                    <x-stencil::combobox.item value="porto-alegre">
                                                        Porto Alegre</x-stencil::combobox.item>
                                                    <x-stencil::combobox.item value="sao-paulo">
                                                        São Paulo</x-stencil::combobox.item>
                                                    <x-stencil::combobox.item value="curitiba">
                                                        Curitiba</x-stencil::combobox.item>
                                                </x-stencil::combobox.group>
                                                <x-stencil::combobox.separator />
                                                <x-stencil::combobox.group>
                                                    <x-stencil::combobox.label>Elsewhere</x-stencil::combobox.label>
                                                    <x-stencil::combobox.item value="lisbon">
                                                        Lisbon</x-stencil::combobox.item>
                                                    <x-stencil::combobox.item value="berlin">
                                                        Berlin</x-stencil::combobox.item>
                                                </x-stencil::combobox.group>
                                            </x-stencil::combobox>
                                        </x-stencil::field>
                                    </div>

                                    <x-stencil::field name="tags">
                                        <x-stencil::field.label>Topics</x-stencil::field.label>
                                        <x-stencil::pillbox
                                            name="tags"
                                            :value="['laravel', 'blade', 'accessibility']"
                                            placeholder="Add a topic…"
                                        />
                                    </x-stencil::field>

                                    <x-stencil::field name="brand_color">
                                        <x-stencil::field.label>Brand color</x-stencil::field.label>
                                        <x-stencil::color-picker name="brand_color" value="#0f766e" class="max-w-xs" />
                                    </x-stencil::field>

                                    <x-stencil::field name="cover">
                                        <x-stencil::field.label>Cover image</x-stencil::field.label>
                                        <x-stencil::file-upload
                                            name="cover"
                                            accept="image/*"
                                            text="PNG or JPG up to 5MB"
                                        />
                                    </x-stencil::field>
                                </x-stencil::card.content>
                                <x-stencil::card.footer class="flex flex-wrap justify-end gap-2">
                                    <x-stencil::button type="button" variant="ghost">Discard</x-stencil::button>
                                    <x-stencil::button type="submit" variant="primary">Save details</x-stencil::button>
                                </x-stencil::card.footer>
                            </x-stencil::card>

                            <x-stencil::card>
                                <x-stencil::card.header>
                                    <x-stencil::card.title>Ticketing</x-stencil::card.title>
                                    <x-stencil::card.description>
                                        Capacity, price range, and visibility.</x-stencil::card.description>
                                </x-stencil::card.header>
                                <x-stencil::card.content class="space-y-5">
                                    <x-stencil::radio.group name="access" legend="Access model">
                                        <x-stencil::radio value="free">Free RSVP</x-stencil::radio>
                                        <x-stencil::radio value="paid" :checked="true">Paid tickets</x-stencil::radio>
                                        <x-stencil::radio value="invite">Invite only</x-stencil::radio>
                                    </x-stencil::radio.group>

                                    <x-stencil::field name="base_price">
                                        <x-stencil::field.label>Early-bird price</x-stencil::field.label>
                                        <x-stencil::input.currency
                                            name="base_price"
                                            :value="189.0"
                                            currency="BRL"
                                            locale="pt_BR"
                                            :precision="2"
                                            placeholder="0,00"
                                            class="max-w-xs"
                                        />
                                    </x-stencil::field>

                                    <x-stencil::field name="capacity">
                                        <x-stencil::field.label>Venue capacity</x-stencil::field.label>
                                        <x-stencil::slider
                                            name="capacity"
                                            :value="320"
                                            :min="50"
                                            :max="800"
                                            class="max-w-md"
                                        />
                                        <x-stencil::field.description>
                                            Soft cap for waitlist messaging.</x-stencil::field.description>
                                    </x-stencil::field>

                                    <x-stencil::field name="expected_score">
                                        <x-stencil::field.label>Internal readiness</x-stencil::field.label>
                                        <x-stencil::rating name="expected_score" :value="4" :max="5" />
                                    </x-stencil::field>

                                    <x-stencil::separator />

                                    <x-stencil::field name="waitlist" orientation="inline">
                                        <div class="flex min-w-0 flex-1 flex-col gap-1">
                                            <x-stencil::field.label>Enable waitlist</x-stencil::field.label>
                                            <x-stencil::field.description>
                                                When capacity is reached.</x-stencil::field.description>
                                        </div>
                                        <x-stencil::switch name="waitlist" :checked="true" />
                                    </x-stencil::field>

                                    <x-stencil::field name="code_of_conduct" orientation="inline">
                                        <x-stencil::checkbox name="code_of_conduct" value="1" :checked="true" />
                                        <x-stencil::field.label>
                                            Require code of conduct acknowledgment</x-stencil::field.label>
                                    </x-stencil::field>
                                </x-stencil::card.content>
                            </x-stencil::card>
                        </div>

                        <aside class="space-y-4">
                            <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900/60">
                                <x-stencil::heading :level="3" class="text-base!">Live activity</x-stencil::heading>
                                <x-stencil::text size="sm" variant="subtle" class="mt-1">Refreshing…</x-stencil::text>
                                <div class="mt-4 space-y-4">
                                    <div class="flex items-center gap-3">
                                        <x-stencil::skeleton rounded="full" class="size-9" />
                                        <div class="flex-1 space-y-2">
                                            <x-stencil::skeleton class="h-3 w-28" />
                                            <x-stencil::skeleton class="h-3 w-40" />
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <x-stencil::skeleton rounded="full" class="size-9" />
                                        <div class="flex-1 space-y-2">
                                            <x-stencil::skeleton class="h-3 w-24" />
                                            <x-stencil::skeleton class="h-3 w-36" />
                                        </div>
                                    </div>
                                    <x-stencil::skeleton class="h-20 w-full rounded-lg" />
                                </div>
                            </div>

                            <div
                                class="relative rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900/60"
                                x-data="{ open: false }"
                            >
                                <div class="flex items-center justify-between gap-2">
                                    <x-stencil::heading :level="3" class="text-base!">Quick filters</x-stencil::heading>
                                    <x-stencil::button
                                        type="button"
                                        variant="ghost"
                                        size="sm"
                                        x-on:click="open = ! open"
                                    >
                                        Filters
                                    </x-stencil::button>
                                </div>
                                <x-stencil::popover
                                    class="absolute! top-auto! right-4! bottom-auto! left-4! mt-3 w-auto! max-w-none! shadow-md!"
                                    x-bind:data-state="open ? 'open' : 'closed'"
                                >
                                    <div class="space-y-3">
                                        <x-stencil::field name="filter_track">
                                            <x-stencil::field.label>Track</x-stencil::field.label>
                                            <x-stencil::select name="filter_track" size="sm" placeholder="Any track">
                                                <x-stencil::select.item value="all">Any track</x-stencil::select.item>
                                                <x-stencil::select.item value="core">Core</x-stencil::select.item>
                                                <x-stencil::select.item value="ui">UI</x-stencil::select.item>
                                            </x-stencil::select>
                                        </x-stencil::field>
                                        <x-stencil::button
                                            type="button"
                                            variant="secondary"
                                            size="sm"
                                            class="w-full"
                                            x-on:click="open = false"
                                        >
                                            Apply filters
                                        </x-stencil::button>
                                    </div>
                                </x-stencil::popover>
                            </div>
                        </aside>
                    </div>
                </x-stencil::tabs.content>

                {{-- Schedule --}}
                <x-stencil::tabs.content value="schedule" class="mt-6!">
                    <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_20rem]">
                        <div class="space-y-6">
                            <x-stencil::card>
                                <x-stencil::card.header>
                                    <x-stencil::card.title>When &amp; where</x-stencil::card.title>
                                    <x-stencil::card.description>
                                        Date, doors, and kickoff datetime.</x-stencil::card.description>
                                </x-stencil::card.header>
                                <x-stencil::card.content class="grid gap-5 sm:grid-cols-2">
                                    <x-stencil::field name="event_date">
                                        <x-stencil::field.label>Event date</x-stencil::field.label>
                                        <x-stencil::date-picker name="event_date" value="2026-09-18" with-today />
                                    </x-stencil::field>

                                    <x-stencil::field name="doors_open">
                                        <x-stencil::field.label>Doors open</x-stencil::field.label>
                                        <x-stencil::time-picker name="doors_open" value="08:30" />
                                    </x-stencil::field>

                                    <x-stencil::field name="kickoff_at" class="sm:col-span-2">
                                        <x-stencil::field.label>Keynote starts</x-stencil::field.label>
                                        <x-stencil::datetime-picker name="kickoff_at" value="2026-09-18T09:15" />
                                    </x-stencil::field>
                                </x-stencil::card.content>
                            </x-stencil::card>

                            <x-stencil::card>
                                <x-stencil::card.header>
                                    <x-stencil::card.title>Sessions</x-stencil::card.title>
                                    <x-stencil::card.description>
                                        Repeating rows for the day schedule.</x-stencil::card.description>
                                </x-stencil::card.header>
                                <x-stencil::card.content>
                                    <x-stencil::repeater
                                        name="sessions"
                                        :value="[
                                            ['title' => 'Opening keynote', 'room' => 'Main hall'],
                                            ['title' => 'Composable Blade panels', 'room' => 'Room B'],
                                        ]"
                                        :min="1"
                                        class="w-full"
                                    >
                                        <x-stencil::repeater.item>
                                            <div class="grid gap-3 sm:grid-cols-2">
                                                <x-stencil::input
                                                    data-repeater-field="title"
                                                    placeholder="Session title"
                                                />
                                                <x-stencil::input data-repeater-field="room" placeholder="Room" />
                                            </div>
                                            <x-stencil::repeater.remove />
                                        </x-stencil::repeater.item>
                                        <x-stencil::repeater.add>Add session</x-stencil::repeater.add>
                                    </x-stencil::repeater>
                                </x-stencil::card.content>
                            </x-stencil::card>
                        </div>

                        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900/60">
                            <x-stencil::heading :level="3" class="text-base!">Month view</x-stencil::heading>
                            <x-stencil::text size="sm" variant="subtle" class="mt-1 mb-4">
                                Standalone calendar for blocking hold dates.
                            </x-stencil::text>
                            <x-stencil::calendar name="hold_date" value="2026-09-18" with-today />
                        </div>
                    </div>
                </x-stencil::tabs.content>

                {{-- Guests --}}
                <x-stencil::tabs.content value="guests" class="mt-6!">
                    <div class="space-y-6">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                            <div class="space-y-1">
                                <x-stencil::heading :level="2" class="text-xl!">Registrations</x-stencil::heading>
                                <x-stencil::text size="sm" variant="subtle">
                                    Latest ticket holders and check-in status.
                                </x-stencil::text>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <x-stencil::button type="button" variant="outline" size="sm">
                                    <x-stencil::icon name="upload" class="size-4" />
                                    Import CSV
                                </x-stencil::button>
                                <x-stencil::button type="button" variant="secondary" size="sm">
                                    <x-stencil::icon name="plus" class="size-4" />
                                    Add guest
                                </x-stencil::button>
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
                            <x-stencil::table>
                                <x-stencil::table.caption>Page 2 of recent registrations</x-stencil::table.caption>
                                <x-stencil::table.header>
                                    <x-stencil::table.row>
                                        <x-stencil::table.head>Guest</x-stencil::table.head>
                                        <x-stencil::table.head>Ticket</x-stencil::table.head>
                                        <x-stencil::table.head>Status</x-stencil::table.head>
                                        <x-stencil::table.head class="text-right">Paid</x-stencil::table.head>
                                    </x-stencil::table.row>
                                </x-stencil::table.header>
                                <x-stencil::table.body>
                                    <x-stencil::table.row>
                                        <x-stencil::table.cell variant="strong">
                                            <div class="flex items-center gap-3">
                                                <x-stencil::avatar
                                                    name="Taylor Otwell"
                                                    size="sm"
                                                    circle
                                                    color="indigo"
                                                />
                                                Taylor Otwell
                                            </div>
                                        </x-stencil::table.cell>
                                        <x-stencil::table.cell>Pro pass</x-stencil::table.cell>
                                        <x-stencil::table.cell>
                                            <x-stencil::badge color="green" rounded>Checked in</x-stencil::badge>
                                        </x-stencil::table.cell>
                                        <x-stencil::table.cell class="text-right">R$ 189,00</x-stencil::table.cell>
                                    </x-stencil::table.row>
                                    <x-stencil::table.row>
                                        <x-stencil::table.cell variant="strong">
                                            <div class="flex items-center gap-3">
                                                <x-stencil::avatar name="Nuno Maduro" size="sm" circle color="rose" />
                                                Nuno Maduro
                                            </div>
                                        </x-stencil::table.cell>
                                        <x-stencil::table.cell>Workshop</x-stencil::table.cell>
                                        <x-stencil::table.cell>
                                            <x-stencil::badge color="amber" rounded>Pending</x-stencil::badge>
                                        </x-stencil::table.cell>
                                        <x-stencil::table.cell class="text-right">R$ 320,00</x-stencil::table.cell>
                                    </x-stencil::table.row>
                                    <x-stencil::table.row>
                                        <x-stencil::table.cell variant="strong">
                                            <div class="flex items-center gap-3">
                                                <x-stencil::avatar name="Jess Archer" size="sm" circle color="violet" />
                                                Jess Archer
                                            </div>
                                        </x-stencil::table.cell>
                                        <x-stencil::table.cell>Community</x-stencil::table.cell>
                                        <x-stencil::table.cell>
                                            <x-stencil::badge variant="outline" rounded>Refunded</x-stencil::badge>
                                        </x-stencil::table.cell>
                                        <x-stencil::table.cell class="text-right">R$ 0,00</x-stencil::table.cell>
                                    </x-stencil::table.row>
                                </x-stencil::table.body>
                            </x-stencil::table>
                        </div>

                        <x-stencil::pagination>
                            <x-stencil::pagination.content>
                                <x-stencil::pagination.item>
                                    <x-stencil::pagination.previous href="#guests" />
                                </x-stencil::pagination.item>
                                <x-stencil::pagination.item>
                                    <x-stencil::pagination.link href="#guests">1</x-stencil::pagination.link>
                                </x-stencil::pagination.item>
                                <x-stencil::pagination.item>
                                    <x-stencil::pagination.link href="#guests" :is-active="true">
                                        2</x-stencil::pagination.link>
                                </x-stencil::pagination.item>
                                <x-stencil::pagination.item>
                                    <x-stencil::pagination.link href="#guests">3</x-stencil::pagination.link>
                                </x-stencil::pagination.item>
                                <x-stencil::pagination.item>
                                    <x-stencil::pagination.ellipsis />
                                </x-stencil::pagination.item>
                                <x-stencil::pagination.item>
                                    <x-stencil::pagination.link href="#guests">12</x-stencil::pagination.link>
                                </x-stencil::pagination.item>
                                <x-stencil::pagination.item>
                                    <x-stencil::pagination.next href="#guests" />
                                </x-stencil::pagination.item>
                            </x-stencil::pagination.content>
                        </x-stencil::pagination>

                        <x-stencil::card>
                            <x-stencil::card.header>
                                <x-stencil::card.title>Door staff PIN</x-stencil::card.title>
                                <x-stencil::card.description>
                                    Six-digit code for offline check-in devices.
                                </x-stencil::card.description>
                            </x-stencil::card.header>
                            <x-stencil::card.content>
                                <x-stencil::input-otp name="door_pin" />
                            </x-stencil::card.content>
                        </x-stencil::card>
                    </div>
                </x-stencil::tabs.content>

                {{-- Settings --}}
                <x-stencil::tabs.content value="settings" class="mt-6!">
                    <div class="mx-auto max-w-2xl space-y-6">
                        <x-stencil::card>
                            <x-stencil::card.header>
                                <x-stencil::card.title>Advanced</x-stencil::card.title>
                                <x-stencil::card.description>
                                    Optional tooling most organizers leave closed.</x-stencil::card.description>
                            </x-stencil::card.header>
                            <x-stencil::card.content class="space-y-4">
                                <x-stencil::collapsible>
                                    <x-stencil::collapsible.trigger>
                                        Webhook &amp; integrations</x-stencil::collapsible.trigger>
                                    <x-stencil::collapsible.content class="mt-3 space-y-4">
                                        <x-stencil::field name="webhook_url">
                                            <x-stencil::field.label>Webhook URL</x-stencil::field.label>
                                            <x-stencil::input
                                                name="webhook_url"
                                                type="url"
                                                placeholder="https://hooks.example.test/events"
                                            />
                                        </x-stencil::field>
                                        <x-stencil::alert variant="info" title="Tip" icon="clipboard">
                                            <x-stencil::alert.description>
                                                We retry failed deliveries for 24 hours with exponential backoff.
                                            </x-stencil::alert.description>
                                        </x-stencil::alert>
                                    </x-stencil::collapsible.content>
                                </x-stencil::collapsible>

                                <x-stencil::separator />

                                <x-stencil::accordion exclusive bordered>
                                    <x-stencil::accordion.item value="refunds" :expanded="true">
                                        <x-stencil::accordion.trigger>
                                            What is the refund policy?</x-stencil::accordion.trigger>
                                        <x-stencil::accordion.content>
                                            Full refunds until 14 days before the event. After that, tickets convert to
                                            credit for next year.
                                        </x-stencil::accordion.content>
                                    </x-stencil::accordion.item>
                                    <x-stencil::accordion.item heading="Can I transfer a ticket?">
                                        Yes — transfers stay open until doors open on day one.
                                    </x-stencil::accordion.item>
                                    <x-stencil::accordion.item heading="How do speakers get access?">
                                        Speakers receive a complimentary Pro pass and a private green-room link.
                                    </x-stencil::accordion.item>
                                </x-stencil::accordion>
                            </x-stencil::card.content>
                            <x-stencil::card.footer class="flex flex-wrap items-center justify-between gap-3">
                                <x-stencil::dialog>
                                    <x-stencil::dialog.trigger>
                                        <x-stencil::button type="button" variant="danger"
                                            >Cancel event</x-stencil::button>
                                    </x-stencil::dialog.trigger>
                                    <x-stencil::dialog.content alert>
                                        <x-stencil::dialog.header>
                                            <x-stencil::dialog.title>Cancel this event?</x-stencil::dialog.title>
                                            <x-stencil::dialog.description>
                                                Guests are emailed automatically. This cannot be undone from the UI.
                                            </x-stencil::dialog.description>
                                        </x-stencil::dialog.header>
                                        <x-stencil::dialog.footer>
                                            <x-stencil::dialog.cancel>Keep event</x-stencil::dialog.cancel>
                                            <x-stencil::dialog.action variant="danger">
                                                Cancel event</x-stencil::dialog.action>
                                        </x-stencil::dialog.footer>
                                    </x-stencil::dialog.content>
                                </x-stencil::dialog>

                                <x-stencil::button type="submit" variant="primary">Save settings</x-stencil::button>
                            </x-stencil::card.footer>
                        </x-stencil::card>
                    </div>
                </x-stencil::tabs.content>
            </x-stencil::tabs>
        </form>
    </div>
@endsection
