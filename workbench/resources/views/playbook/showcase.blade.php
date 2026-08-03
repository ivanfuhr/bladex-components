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
    <x-ui::toast.provider position="bottom-right">
        <x-ui::toast
            variant="success"
            title="Draft autosaved"
            description="Northwind Summit was saved a moment ago."
            :duration="8000"
        />
    </x-ui::toast.provider>

    <div class="space-y-8">
        {{-- Wayfinding --}}
        <x-ui::breadcrumb>
            <x-ui::breadcrumb.list>
                <x-ui::breadcrumb.item :href="route('playbook.index')">Playbook</x-ui::breadcrumb.item>
                <x-ui::breadcrumb.separator />
                <x-ui::breadcrumb.item :href="route('playbook.showcase')">Showcase</x-ui::breadcrumb.item>
                <x-ui::breadcrumb.separator />
                <x-ui::breadcrumb.item>
                    <x-ui::breadcrumb.page>Northwind Summit</x-ui::breadcrumb.page>
                </x-ui::breadcrumb.item>
            </x-ui::breadcrumb.list>
        </x-ui::breadcrumb>

        {{-- Page header --}}
        <header class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div class="min-w-0 space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                    <x-ui::heading :level="1">Northwind Summit 2026</x-ui::heading>
                    <x-ui::badge color="amber" rounded>Draft</x-ui::badge>
                    <x-ui::badge variant="outline" rounded>Public page</x-ui::badge>
                </div>
                <x-ui::text variant="subtle" class="max-w-prose">
                    Real-world composition of Stencil components — an event editor an organizer would actually use.
                    Illustrative data only.
                </x-ui::text>
                <div class="flex flex-wrap items-center gap-3 pt-1">
                    <x-ui::avatar.group>
                        <x-ui::avatar name="Ada Lovelace" circle color="violet" />
                        <x-ui::avatar name="Grace Hopper" circle color="blue" />
                        <x-ui::avatar name="Alan Turing" circle color="green" />
                    </x-ui::avatar.group>
                    <x-ui::text size="sm" variant="subtle">3 organizers</x-ui::text>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <x-ui::tooltip side="bottom">
                    <x-ui::tooltip.trigger>
                        <x-ui::button variant="outline" square aria-label="Preview public page">
                            <x-ui::icon name="eye" class="size-4" />
                        </x-ui::button>
                    </x-ui::tooltip.trigger>
                    <x-ui::tooltip.content>Preview public page</x-ui::tooltip.content>
                </x-ui::tooltip>

                <x-ui::dropdown-menu align="end">
                    <x-ui::dropdown-menu.trigger>
                        <x-ui::button variant="outline">
                            More
                            <x-ui::icon name="chevron-down" class="size-4 opacity-60" />
                        </x-ui::button>
                    </x-ui::dropdown-menu.trigger>
                    <x-ui::dropdown-menu.content>
                        <x-ui::dropdown-menu.label>Event</x-ui::dropdown-menu.label>
                        <x-ui::dropdown-menu.item>
                            Duplicate
                            <x-ui::dropdown-menu.shortcut>⌘D</x-ui::dropdown-menu.shortcut>
                        </x-ui::dropdown-menu.item>
                        <x-ui::dropdown-menu.item>
                            Export CSV
                            <x-ui::dropdown-menu.shortcut>⌘E</x-ui::dropdown-menu.shortcut>
                        </x-ui::dropdown-menu.item>
                        <x-ui::dropdown-menu.separator />
                        <x-ui::dropdown-menu.item variant="danger"> Archive event </x-ui::dropdown-menu.item>
                    </x-ui::dropdown-menu.content>
                </x-ui::dropdown-menu>

                <x-ui::dialog>
                    <x-ui::dialog.trigger>
                        <x-ui::button variant="primary">Publish event</x-ui::button>
                    </x-ui::dialog.trigger>
                    <x-ui::dialog.content>
                        <x-ui::dialog.header>
                            <x-ui::dialog.title>Publish Northwind Summit?</x-ui::dialog.title>
                            <x-ui::dialog.description>
                                The public page goes live and ticket sales open immediately.
                            </x-ui::dialog.description>
                        </x-ui::dialog.header>
                        <div class="mt-4 space-y-3">
                            <x-ui::field name="publish_note">
                                <x-ui::field.label>Release note</x-ui::field.label>
                                <x-ui::input name="publish_note" placeholder="What changed for attendees?" />
                                <x-ui::field.description>
                                    Shown once in the organizer activity feed.</x-ui::field.description>
                            </x-ui::field>
                        </div>
                        <x-ui::dialog.footer>
                            <x-ui::dialog.cancel>Keep drafting</x-ui::dialog.cancel>
                            <x-ui::dialog.action variant="primary">Publish now</x-ui::dialog.action>
                        </x-ui::dialog.footer>
                    </x-ui::dialog.content>
                </x-ui::dialog>
            </div>
        </header>

        {{-- Status strip --}}
        <div class="space-y-3">
            <x-ui::alert variant="warning" icon="clipboard">
                <x-ui::text class="leading-none font-medium tracking-tight">
                    Finish setup before publishing
                </x-ui::text>
                <x-ui::alert.description>
                    Add at least one ticket tier and confirm the venue capacity. Your public page stays gated until
                    then.
                </x-ui::alert.description>
            </x-ui::alert>
            <div class="space-y-2">
                <div class="flex items-center justify-between gap-3" id="setup-progress-label">
                    <x-ui::text size="sm" variant="subtle">Setup progress</x-ui::text>
                    <x-ui::text size="sm" class="font-medium tabular-nums">72%</x-ui::text>
                </div>
                <x-ui::progress :value="72" aria-labelledby="setup-progress-label" />
            </div>
        </div>

        <x-ui::separator />

        {{-- Main workspace --}}
        <form action="#" method="post" class="space-y-6" onsubmit="return false;">
            @csrf

            <x-ui::tabs default-value="details" variant="line">
                <x-ui::tabs.list>
                    <x-ui::tabs.trigger value="details">Details</x-ui::tabs.trigger>
                    <x-ui::tabs.trigger value="schedule">Schedule</x-ui::tabs.trigger>
                    <x-ui::tabs.trigger value="guests">Guests</x-ui::tabs.trigger>
                    <x-ui::tabs.trigger value="settings">Settings</x-ui::tabs.trigger>
                </x-ui::tabs.list>

                {{-- Details --}}
                <x-ui::tabs.content value="details" class="mt-6!">
                    <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_18rem]">
                        <div class="space-y-6">
                            <x-ui::heading :level="2" class="sr-only">Details</x-ui::heading>
                            <x-ui::card>
                                <x-ui::card.header>
                                    <x-ui::card.title>Event profile</x-ui::card.title>
                                    <x-ui::card.description>
                                        Basics shown on the public landing page and tickets.
                                    </x-ui::card.description>
                                </x-ui::card.header>
                                <x-ui::card.content class="space-y-5">
                                    <x-ui::field name="title">
                                        <x-ui::field.label :required="true">Title</x-ui::field.label>
                                        <x-ui::input name="title" value="Northwind Summit 2026" />
                                    </x-ui::field>

                                    <x-ui::field name="slug">
                                        <x-ui::label for="slug">Public URL</x-ui::label>
                                        <x-ui::input
                                            id="slug"
                                            name="slug"
                                            prefix="https://"
                                            suffix=".events.test"
                                            value="northwind-summit"
                                        />
                                        <x-ui::field.description>
                                            Lowercase letters, numbers, and hyphens.</x-ui::field.description>
                                    </x-ui::field>

                                    <x-ui::field name="summary">
                                        <x-ui::field.label>Summary</x-ui::field.label>
                                        <x-ui::textarea
                                            name="summary"
                                            rows="3"
                                            placeholder="One short paragraph for search results and invites…"
                                            >Two days of talks, workshops, and hallway track for Laravel teams shipping
                                            Blade UIs.</x-ui::textarea>
                                    </x-ui::field>

                                    <div class="grid gap-5 sm:grid-cols-2">
                                        <x-ui::field name="format">
                                            <x-ui::field.label>Format</x-ui::field.label>
                                            <x-ui::select name="format" placeholder="Choose format…">
                                                <x-ui::select.group>
                                                    <x-ui::select.label>In person</x-ui::select.label>
                                                    <x-ui::select.item value="conference">
                                                        Conference</x-ui::select.item>
                                                    <x-ui::select.item value="workshop"> Workshop</x-ui::select.item>
                                                </x-ui::select.group>
                                                <x-ui::select.separator />
                                                <x-ui::select.item value="hybrid">Hybrid</x-ui::select.item>
                                                <x-ui::select.item value="online"> Online only</x-ui::select.item>
                                            </x-ui::select>
                                        </x-ui::field>

                                        <x-ui::field name="venue_city">
                                            <x-ui::field.label>City</x-ui::field.label>
                                            <x-ui::combobox
                                                name="venue_city"
                                                placeholder="Search cities…"
                                                value="porto-alegre"
                                            >
                                                <x-ui::combobox.group>
                                                    <x-ui::combobox.label>Brazil</x-ui::combobox.label>
                                                    <x-ui::combobox.item value="porto-alegre">
                                                        Porto Alegre</x-ui::combobox.item>
                                                    <x-ui::combobox.item value="sao-paulo">
                                                        São Paulo</x-ui::combobox.item>
                                                    <x-ui::combobox.item value="curitiba">
                                                        Curitiba</x-ui::combobox.item>
                                                </x-ui::combobox.group>
                                                <x-ui::combobox.separator />
                                                <x-ui::combobox.group>
                                                    <x-ui::combobox.label>Elsewhere</x-ui::combobox.label>
                                                    <x-ui::combobox.item value="lisbon"> Lisbon</x-ui::combobox.item>
                                                    <x-ui::combobox.item value="berlin"> Berlin</x-ui::combobox.item>
                                                </x-ui::combobox.group>
                                            </x-ui::combobox>
                                        </x-ui::field>
                                    </div>

                                    <x-ui::field name="tags">
                                        <x-ui::field.label>Topics</x-ui::field.label>
                                        <x-ui::pillbox
                                            name="tags"
                                            :value="['laravel', 'blade', 'accessibility']"
                                            placeholder="Add a topic…"
                                        />
                                    </x-ui::field>

                                    <x-ui::field name="brand_color">
                                        <x-ui::field.label>Brand color</x-ui::field.label>
                                        <x-ui::color-picker name="brand_color" value="#0f766e" class="max-w-xs" />
                                    </x-ui::field>

                                    <x-ui::field name="cover">
                                        <x-ui::field.label>Cover image</x-ui::field.label>
                                        <x-ui::file-upload name="cover" accept="image/*" text="PNG or JPG up to 5MB" />
                                    </x-ui::field>
                                </x-ui::card.content>
                                <x-ui::card.footer class="flex flex-wrap justify-end gap-2">
                                    <x-ui::button type="button" variant="ghost">Discard</x-ui::button>
                                    <x-ui::button type="submit" variant="primary">Save details</x-ui::button>
                                </x-ui::card.footer>
                            </x-ui::card>

                            <x-ui::card>
                                <x-ui::card.header>
                                    <x-ui::card.title>Ticketing</x-ui::card.title>
                                    <x-ui::card.description>
                                        Capacity, price range, and visibility.</x-ui::card.description>
                                </x-ui::card.header>
                                <x-ui::card.content class="space-y-5">
                                    <x-ui::radio.group name="access" legend="Access model">
                                        <x-ui::radio value="free">Free RSVP</x-ui::radio>
                                        <x-ui::radio value="paid" :checked="true">Paid tickets</x-ui::radio>
                                        <x-ui::radio value="invite">Invite only</x-ui::radio>
                                    </x-ui::radio.group>

                                    <x-ui::field name="base_price">
                                        <x-ui::field.label>Early-bird price</x-ui::field.label>
                                        <x-ui::input.currency
                                            name="base_price"
                                            :value="189.0"
                                            currency="BRL"
                                            locale="pt_BR"
                                            :precision="2"
                                            placeholder="0,00"
                                            class="max-w-xs"
                                        />
                                    </x-ui::field>

                                    <x-ui::field name="capacity">
                                        <x-ui::field.label>Venue capacity</x-ui::field.label>
                                        <x-ui::slider
                                            name="capacity"
                                            :value="320"
                                            :min="50"
                                            :max="800"
                                            class="max-w-md"
                                        />
                                        <x-ui::field.description>
                                            Soft cap for waitlist messaging.</x-ui::field.description>
                                    </x-ui::field>

                                    <x-ui::field name="expected_score">
                                        <x-ui::field.label>Internal readiness</x-ui::field.label>
                                        <x-ui::rating name="expected_score" :value="4" :max="5" />
                                    </x-ui::field>

                                    <x-ui::separator />

                                    <x-ui::field name="waitlist" orientation="inline">
                                        <div class="flex min-w-0 flex-1 flex-col gap-1">
                                            <x-ui::field.label>Enable waitlist</x-ui::field.label>
                                            <x-ui::field.description>
                                                When capacity is reached.</x-ui::field.description>
                                        </div>
                                        <x-ui::switch name="waitlist" :checked="true" />
                                    </x-ui::field>

                                    <x-ui::field name="code_of_conduct" orientation="inline">
                                        <x-ui::checkbox name="code_of_conduct" value="1" :checked="true" />
                                        <x-ui::field.label> Require code of conduct acknowledgment</x-ui::field.label>
                                    </x-ui::field>
                                </x-ui::card.content>
                            </x-ui::card>
                        </div>

                        <aside class="space-y-4" aria-label="Event sidebar">
                            <div
                                class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900/60"
                                aria-busy="true"
                                aria-live="polite"
                            >
                                <x-ui::heading :level="3" class="text-base!">Live activity</x-ui::heading>
                                <x-ui::text size="sm" variant="subtle" class="mt-1">Refreshing…</x-ui::text>
                                <div class="mt-4 space-y-4">
                                    <div class="flex items-center gap-3">
                                        <x-ui::skeleton rounded="full" class="size-9" />
                                        <div class="flex-1 space-y-2">
                                            <x-ui::skeleton class="h-3 w-28" />
                                            <x-ui::skeleton class="h-3 w-40" />
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <x-ui::skeleton rounded="full" class="size-9" />
                                        <div class="flex-1 space-y-2">
                                            <x-ui::skeleton class="h-3 w-24" />
                                            <x-ui::skeleton class="h-3 w-36" />
                                        </div>
                                    </div>
                                    <x-ui::skeleton class="h-20 w-full rounded-lg" />
                                </div>
                            </div>

                            <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900/60">
                                <div class="flex items-center justify-between gap-2">
                                    <x-ui::heading :level="3" class="text-base!">Quick filters</x-ui::heading>
                                    <x-ui::popover align="end" side="bottom">
                                        <x-ui::popover.trigger>
                                            <x-ui::button type="button" variant="ghost" size="sm">
                                                Filters
                                            </x-ui::button>
                                        </x-ui::popover.trigger>
                                        <x-ui::popover.content class="w-72">
                                            <div class="space-y-3">
                                                <x-ui::field name="filter_track">
                                                    <x-ui::field.label>Track</x-ui::field.label>
                                                    <x-ui::select name="filter_track" size="sm" placeholder="Any track">
                                                        <x-ui::select.item value="all"> Any track</x-ui::select.item>
                                                        <x-ui::select.item value="core"> Core</x-ui::select.item>
                                                        <x-ui::select.item value="ui">UI</x-ui::select.item>
                                                    </x-ui::select>
                                                </x-ui::field>
                                                <x-ui::button
                                                    type="button"
                                                    variant="secondary"
                                                    size="sm"
                                                    class="w-full"
                                                    data-popover-close
                                                >
                                                    Apply filters
                                                </x-ui::button>
                                            </div>
                                        </x-ui::popover.content>
                                    </x-ui::popover>
                                </div>
                            </div>
                        </aside>
                    </div>
                </x-ui::tabs.content>

                {{-- Schedule --}}
                <x-ui::tabs.content value="schedule" class="mt-6!">
                    <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_20rem]">
                        <div class="space-y-6">
                            <x-ui::heading :level="2" class="sr-only">Schedule</x-ui::heading>
                            <x-ui::card>
                                <x-ui::card.header>
                                    <x-ui::card.title>When &amp; where</x-ui::card.title>
                                    <x-ui::card.description> Date, doors, and kickoff datetime.</x-ui::card.description>
                                </x-ui::card.header>
                                <x-ui::card.content class="grid gap-5 sm:grid-cols-2">
                                    <x-ui::field name="event_date">
                                        <x-ui::field.label>Event date</x-ui::field.label>
                                        <x-ui::date-picker name="event_date" value="2026-09-18" with-today />
                                    </x-ui::field>

                                    <x-ui::field name="doors_open">
                                        <x-ui::field.label>Doors open</x-ui::field.label>
                                        <x-ui::time-picker name="doors_open" value="08:30" />
                                    </x-ui::field>

                                    <x-ui::field name="kickoff_at" class="sm:col-span-2">
                                        <x-ui::field.label>Keynote starts</x-ui::field.label>
                                        <x-ui::datetime-picker name="kickoff_at" value="2026-09-18T09:15" />
                                    </x-ui::field>
                                </x-ui::card.content>
                            </x-ui::card>

                            <x-ui::card>
                                <x-ui::card.header>
                                    <x-ui::card.title>Sessions</x-ui::card.title>
                                    <x-ui::card.description>
                                        Repeating rows for the day schedule.</x-ui::card.description>
                                </x-ui::card.header>
                                <x-ui::card.content>
                                    <x-ui::repeater
                                        name="sessions"
                                        :value="[
                                            ['title' => 'Opening keynote', 'room' => 'Main hall'],
                                            ['title' => 'Composable Blade panels', 'room' => 'Room B'],
                                        ]"
                                        :min="1"
                                        class="w-full"
                                    >
                                        <x-ui::repeater.item>
                                            <div class="grid gap-3 sm:grid-cols-2">
                                                <x-ui::input data-repeater-field="title" placeholder="Session title" />
                                                <x-ui::input data-repeater-field="room" placeholder="Room" />
                                            </div>
                                            <x-ui::repeater.remove />
                                        </x-ui::repeater.item>
                                        <x-ui::repeater.add>Add session</x-ui::repeater.add>
                                    </x-ui::repeater>
                                </x-ui::card.content>
                            </x-ui::card>
                        </div>

                        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900/60">
                            <x-ui::heading :level="3" class="text-base!">Month view</x-ui::heading>
                            <x-ui::text size="sm" variant="subtle" class="mt-1 mb-4">
                                Standalone calendar for blocking hold dates.
                            </x-ui::text>
                            <x-ui::calendar name="hold_date" value="2026-09-18" with-today />
                        </div>
                    </div>
                </x-ui::tabs.content>

                {{-- Guests --}}
                <x-ui::tabs.content value="guests" class="mt-6!" id="guests">
                    <div class="space-y-6">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                            <div class="space-y-1">
                                <x-ui::heading :level="2" class="text-xl!">Registrations</x-ui::heading>
                                <x-ui::text size="sm" variant="subtle">
                                    Latest ticket holders and check-in status.
                                </x-ui::text>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <x-ui::button type="button" variant="outline" size="sm">
                                    <x-ui::icon name="upload" class="size-4" />
                                    Import CSV
                                </x-ui::button>
                                <x-ui::button type="button" variant="secondary" size="sm">
                                    <x-ui::icon name="plus" class="size-4" />
                                    Add guest
                                </x-ui::button>
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
                            <x-ui::table>
                                <x-ui::table.caption>Page 2 of recent registrations</x-ui::table.caption>
                                <x-ui::table.header>
                                    <x-ui::table.row>
                                        <x-ui::table.head>Guest</x-ui::table.head>
                                        <x-ui::table.head>Ticket</x-ui::table.head>
                                        <x-ui::table.head>Status</x-ui::table.head>
                                        <x-ui::table.head class="text-right">Paid</x-ui::table.head>
                                    </x-ui::table.row>
                                </x-ui::table.header>
                                <x-ui::table.body>
                                    <x-ui::table.row>
                                        <x-ui::table.cell variant="strong">
                                            <div class="flex items-center gap-3">
                                                <x-ui::avatar name="Taylor Otwell" size="sm" circle color="indigo" />
                                                Taylor Otwell
                                            </div>
                                        </x-ui::table.cell>
                                        <x-ui::table.cell>Pro pass</x-ui::table.cell>
                                        <x-ui::table.cell>
                                            <x-ui::badge color="green" rounded>Checked in</x-ui::badge>
                                        </x-ui::table.cell>
                                        <x-ui::table.cell class="text-right">R$ 189,00</x-ui::table.cell>
                                    </x-ui::table.row>
                                    <x-ui::table.row>
                                        <x-ui::table.cell variant="strong">
                                            <div class="flex items-center gap-3">
                                                <x-ui::avatar name="Nuno Maduro" size="sm" circle color="rose" />
                                                Nuno Maduro
                                            </div>
                                        </x-ui::table.cell>
                                        <x-ui::table.cell>Workshop</x-ui::table.cell>
                                        <x-ui::table.cell>
                                            <x-ui::badge color="amber" rounded>Pending</x-ui::badge>
                                        </x-ui::table.cell>
                                        <x-ui::table.cell class="text-right">R$ 320,00</x-ui::table.cell>
                                    </x-ui::table.row>
                                    <x-ui::table.row>
                                        <x-ui::table.cell variant="strong">
                                            <div class="flex items-center gap-3">
                                                <x-ui::avatar name="Jess Archer" size="sm" circle color="violet" />
                                                Jess Archer
                                            </div>
                                        </x-ui::table.cell>
                                        <x-ui::table.cell>Community</x-ui::table.cell>
                                        <x-ui::table.cell>
                                            <x-ui::badge variant="outline" rounded>Refunded</x-ui::badge>
                                        </x-ui::table.cell>
                                        <x-ui::table.cell class="text-right">R$ 0,00</x-ui::table.cell>
                                    </x-ui::table.row>
                                </x-ui::table.body>
                            </x-ui::table>
                        </div>

                        <x-ui::pagination>
                            <x-ui::pagination.content>
                                <x-ui::pagination.item>
                                    <x-ui::pagination.previous href="#guests" />
                                </x-ui::pagination.item>
                                <x-ui::pagination.item>
                                    <x-ui::pagination.link href="#guests">1</x-ui::pagination.link>
                                </x-ui::pagination.item>
                                <x-ui::pagination.item>
                                    <x-ui::pagination.link href="#guests" :is-active="true"> 2</x-ui::pagination.link>
                                </x-ui::pagination.item>
                                <x-ui::pagination.item>
                                    <x-ui::pagination.link href="#guests">3</x-ui::pagination.link>
                                </x-ui::pagination.item>
                                <x-ui::pagination.item>
                                    <x-ui::pagination.ellipsis />
                                </x-ui::pagination.item>
                                <x-ui::pagination.item>
                                    <x-ui::pagination.link href="#guests">12</x-ui::pagination.link>
                                </x-ui::pagination.item>
                                <x-ui::pagination.item>
                                    <x-ui::pagination.next href="#guests" />
                                </x-ui::pagination.item>
                            </x-ui::pagination.content>
                        </x-ui::pagination>

                        <x-ui::card>
                            <x-ui::card.header>
                                <x-ui::card.title>Door staff PIN</x-ui::card.title>
                                <x-ui::card.description>
                                    Six-digit code for offline check-in devices.
                                </x-ui::card.description>
                            </x-ui::card.header>
                            <x-ui::card.content>
                                <x-ui::input-otp name="door_pin" />
                            </x-ui::card.content>
                        </x-ui::card>
                    </div>
                </x-ui::tabs.content>

                {{-- Settings --}}
                <x-ui::tabs.content value="settings" class="mt-6!">
                    <div class="mx-auto max-w-2xl space-y-6">
                        <x-ui::heading :level="2" class="sr-only">Settings</x-ui::heading>
                        <x-ui::card>
                            <x-ui::card.header>
                                <x-ui::card.title>Advanced</x-ui::card.title>
                                <x-ui::card.description>
                                    Optional tooling most organizers leave closed.</x-ui::card.description>
                            </x-ui::card.header>
                            <x-ui::card.content class="space-y-4">
                                <x-ui::collapsible>
                                    <x-ui::collapsible.trigger> Webhook &amp; integrations</x-ui::collapsible.trigger>
                                    <x-ui::collapsible.content class="mt-3 space-y-4">
                                        <x-ui::field name="webhook_url">
                                            <x-ui::field.label>Webhook URL</x-ui::field.label>
                                            <x-ui::input
                                                name="webhook_url"
                                                type="url"
                                                placeholder="https://hooks.example.test/events"
                                            />
                                        </x-ui::field>
                                        <x-ui::alert variant="info" icon="clipboard">
                                            <x-ui::text class="leading-none font-medium tracking-tight">Tip</x-ui::text>
                                            <x-ui::alert.description>
                                                We retry failed deliveries for 24 hours with exponential backoff.
                                            </x-ui::alert.description>
                                        </x-ui::alert>
                                    </x-ui::collapsible.content>
                                </x-ui::collapsible>

                                <x-ui::separator />

                                <x-ui::accordion exclusive bordered>
                                    <x-ui::accordion.item value="refunds" :expanded="true">
                                        <x-ui::accordion.trigger> What is the refund policy?</x-ui::accordion.trigger>
                                        <x-ui::accordion.content>
                                            Full refunds until 14 days before the event. After that, tickets convert to
                                            credit for next year.
                                        </x-ui::accordion.content>
                                    </x-ui::accordion.item>
                                    <x-ui::accordion.item heading="Can I transfer a ticket?">
                                        Yes — transfers stay open until doors open on day one.
                                    </x-ui::accordion.item>
                                    <x-ui::accordion.item heading="How do speakers get access?">
                                        Speakers receive a complimentary Pro pass and a private green-room link.
                                    </x-ui::accordion.item>
                                </x-ui::accordion>
                            </x-ui::card.content>
                            <x-ui::card.footer class="flex flex-wrap items-center justify-between gap-3">
                                <x-ui::dialog>
                                    <x-ui::dialog.trigger>
                                        <x-ui::button type="button" variant="danger">Cancel event</x-ui::button>
                                    </x-ui::dialog.trigger>
                                    <x-ui::dialog.content alert>
                                        <x-ui::dialog.header>
                                            <x-ui::dialog.title>Cancel this event?</x-ui::dialog.title>
                                            <x-ui::dialog.description>
                                                Guests are emailed automatically. This cannot be undone from the UI.
                                            </x-ui::dialog.description>
                                        </x-ui::dialog.header>
                                        <x-ui::dialog.footer>
                                            <x-ui::dialog.cancel>Keep event</x-ui::dialog.cancel>
                                            <x-ui::dialog.action variant="danger"> Cancel event</x-ui::dialog.action>
                                        </x-ui::dialog.footer>
                                    </x-ui::dialog.content>
                                </x-ui::dialog>

                                <x-ui::button type="submit" variant="primary">Save settings</x-ui::button>
                            </x-ui::card.footer>
                        </x-ui::card>
                    </div>
                </x-ui::tabs.content>
            </x-ui::tabs>
        </form>
    </div>
@endsection
