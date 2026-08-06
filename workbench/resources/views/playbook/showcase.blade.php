{{--
THESIS: One real Event Studio screen that composes every Std Components primitive in situ — not a prop zoo.
OWN-WORLD: Playbook zinc surfaces, restrained neutrals, Operate density; components carry the craft.
STORY: Organizer finishes Northwind Summit setup — edit details, schedule, guests, then publish.
FIRST VIEWPORT: Breadcrumb + event title + status badges + team avatars + actions; alert + progress; tabbed workspace.
FORM: Established playbook surface extension (Operate); seed n/a.
--}}
@extends('workbench::layouts.playbook')

@section('title', 'Showcase — Event Studio')

@section('content')
    @php
        $insightsData = [
            ['date' => '2026-07-28', 'visitors' => 241],
            ['date' => '2026-07-29', 'visitors' => 259],
            ['date' => '2026-07-30', 'visitors' => 269],
            ['date' => '2026-07-31', 'visitors' => 259],
            ['date' => '2026-08-01', 'visitors' => 267],
        ];
    @endphp

    <x-std::toast.provider position="bottom-right">
        <x-std::toast
            variant="success"
            title="Draft autosaved"
            description="Northwind Summit was saved a moment ago."
            :duration="8000"
        />
    </x-std::toast.provider>

    <x-std::sidebar.provider :default-open="true" storage-key="std-showcase-sidebar" class="h-svh" id="playbook-main">
        <x-std::sidebar collapsible="icon" class="shrink-0">
            <x-std::sidebar.header>
                <x-std::sidebar.menu>
                    <x-std::sidebar.menu-item>
                        <x-std::dropdown-menu side="right" align="start">
                            <x-std::dropdown-menu.trigger>
                                <x-std::sidebar.menu-button
                                    size="lg"
                                    class="data-[state=open]:bg-zinc-100 dark:data-[state=open]:bg-zinc-800"
                                >
                                    <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-zinc-900 text-xs font-bold text-zinc-50 dark:bg-zinc-50 dark:text-zinc-900">
                                        E
                                    </span>
                                    <div class="grid flex-1 text-left text-sm leading-tight group-data-[collapsible=icon]:hidden">
                                        <span class="truncate font-semibold">Event Studio</span>
                                        <span class="truncate text-xs text-zinc-500 dark:text-zinc-400">Enterprise</span>
                                    </div>
                                    <x-std::icon
                                        name="chevron-down"
                                        class="ml-auto size-4 group-data-[collapsible=icon]:hidden"
                                    />
                                </x-std::sidebar.menu-button>
                            </x-std::dropdown-menu.trigger>
                            <x-std::dropdown-menu.content class="min-w-56">
                                <x-std::dropdown-menu.label>Switch workspace</x-std::dropdown-menu.label>
                                <x-std::dropdown-menu.item href="{{ route('playbook.index') }}">
                                    Std Components Playbook
                                </x-std::dropdown-menu.item>
                                <x-std::dropdown-menu.item href="{{ route('playbook.showcase') }}">
                                    Event Studio
                                </x-std::dropdown-menu.item>
                            </x-std::dropdown-menu.content>
                        </x-std::dropdown-menu>
                    </x-std::sidebar.menu-item>
                </x-std::sidebar.menu>
            </x-std::sidebar.header>

            <x-std::sidebar.content>
                <x-std::sidebar.group>
                    <x-std::sidebar.group-label>Events</x-std::sidebar.group-label>
                    <x-std::sidebar.group-content>
                        <x-std::sidebar.menu>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button
                                    href="{{ route('playbook.showcase') }}"
                                    active
                                    tooltip="Northwind Summit"
                                >
                                    <x-std::icon name="star" class="size-4" />
                                    <span>Northwind Summit</span>
                                </x-std::sidebar.menu-button>
                                <x-std::sidebar.menu-badge>72%</x-std::sidebar.menu-badge>
                            </x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#" tooltip="Laravel Day SP">
                                    <x-std::icon name="calendar" class="size-4" />
                                    <span>Laravel Day SP</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                        </x-std::sidebar.menu>
                    </x-std::sidebar.group-content>
                </x-std::sidebar.group>

                <x-std::sidebar.group>
                    <x-std::sidebar.group-label>Projects</x-std::sidebar.group-label>
                    <x-std::sidebar.group-content>
                        <x-std::sidebar.menu>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#details" tooltip="Event profile">
                                    <x-std::icon name="clipboard" class="size-4" />
                                    <span>Event profile</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#schedule" tooltip="Schedule build">
                                    <x-std::icon name="calendar" class="size-4" />
                                    <span>Schedule build</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#guests" tooltip="Guest operations">
                                    <x-std::icon name="eye" class="size-4" />
                                    <span>Guest operations</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="{{ route('playbook.index') }}" tooltip="More">
                                    <x-std::icon name="plus" class="size-4" />
                                    <span>More</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                        </x-std::sidebar.menu>
                    </x-std::sidebar.group-content>
                </x-std::sidebar.group>

                <x-std::sidebar.separator />

                <x-std::sidebar.group>
                    <x-std::sidebar.group-label>Workspace</x-std::sidebar.group-label>
                    <x-std::sidebar.group-content>
                        <x-std::sidebar.menu>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#details" tooltip="Details">
                                    <x-std::icon name="file" class="size-4" />
                                    <span>Details</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#schedule" tooltip="Schedule">
                                    <x-std::icon name="calendar" class="size-4" />
                                    <span>Schedule</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#guests" tooltip="Guests">
                                    <x-std::icon name="clipboard" class="size-4" />
                                    <span>Guests</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#insights" tooltip="Insights">
                                    <x-std::icon name="eye" class="size-4" />
                                    <span>Insights</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-item>
                                <x-std::sidebar.menu-button href="#settings" tooltip="Settings">
                                    <x-std::icon name="star" class="size-4" />
                                    <span>Settings</span>
                                </x-std::sidebar.menu-button>
                            </x-std::sidebar.menu-item>
                        </x-std::sidebar.menu>
                    </x-std::sidebar.group-content>
                </x-std::sidebar.group>
            </x-std::sidebar.content>

            <x-std::sidebar.footer>
                <x-std::sidebar.menu>
                    <x-std::sidebar.menu-item>
                        <x-std::dropdown-menu side="top" align="start">
                            <x-std::dropdown-menu.trigger>
                                <x-std::sidebar.menu-button
                                    size="lg"
                                    class="data-[state=open]:bg-zinc-100 dark:data-[state=open]:bg-zinc-800"
                                >
                                    <x-std::avatar name="Ada Lovelace" size="sm" circle color="violet" />
                                    <div class="grid flex-1 text-left text-sm leading-tight group-data-[collapsible=icon]:hidden">
                                        <span class="truncate font-semibold">Ada Lovelace</span>
                                        <span class="truncate text-xs text-zinc-500 dark:text-zinc-400">organizer@northwind.dev</span>
                                    </div>
                                    <x-std::icon
                                        name="chevron-down"
                                        class="ml-auto size-4 group-data-[collapsible=icon]:hidden"
                                    />
                                </x-std::sidebar.menu-button>
                            </x-std::dropdown-menu.trigger>
                            <x-std::dropdown-menu.content class="min-w-56">
                                <x-std::dropdown-menu.label>Appearance</x-std::dropdown-menu.label>
                                <label class="flex cursor-pointer items-center gap-2 rounded-sm px-2 py-1.5 text-sm text-zinc-700 dark:text-zinc-300">
                                    <input
                                        type="checkbox"
                                        role="switch"
                                        class="size-4 rounded border-zinc-300 text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:border-zinc-600 dark:bg-zinc-950 dark:focus-visible:ring-zinc-300/20"
                                        x-model="dark"
                                        x-bind:aria-checked="dark.toString()"
                                    />
                                    <span>Dark mode</span>
                                </label>
                                <x-std::dropdown-menu.separator />
                                <x-std::dropdown-menu.item href="{{ route('playbook.index') }}">
                                    Back to Playbook
                                </x-std::dropdown-menu.item>
                            </x-std::dropdown-menu.content>
                        </x-std::dropdown-menu>
                    </x-std::sidebar.menu-item>
                </x-std::sidebar.menu>
            </x-std::sidebar.footer>

            <x-std::sidebar.rail />
        </x-std::sidebar>

        <x-std::sidebar.inset>
            <x-std::header>
                <div class="flex w-full items-center gap-2 px-4">
                    <x-std::sidebar.trigger />
                    <x-std::separator orientation="vertical" class="me-2 h-4!" />
                    <x-std::breadcrumb>
                        <x-std::breadcrumb.list>
                            <x-std::breadcrumb.item class="hidden md:block">
                                <x-std::breadcrumb.link href="{{ route('playbook.index') }}">
                                    Build your application
                                </x-std::breadcrumb.link>
                            </x-std::breadcrumb.item>
                            <x-std::breadcrumb.separator class="hidden md:block" />
                            <x-std::breadcrumb.item>
                                <x-std::breadcrumb.page>Northwind Summit</x-std::breadcrumb.page>
                            </x-std::breadcrumb.item>
                        </x-std::breadcrumb.list>
                    </x-std::breadcrumb>
                </div>
            </x-std::header>

            <x-std::main class="gap-8">
                <x-std::header variant="page" :border="false">
                    <div class="min-w-0 space-y-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <x-std::heading :level="1">Northwind Summit 2026</x-std::heading>
                            <x-std::badge color="amber" rounded>Draft</x-std::badge>
                            <x-std::badge variant="outline" rounded>Public page</x-std::badge>
                        </div>
                        <x-std::text variant="subtle" class="max-w-prose">
                            Real-world composition of Std Components components — an event editor an organizer would
                            actually use. Illustrative data only.
                        </x-std::text>
                        <div class="flex flex-wrap items-center gap-3 pt-1">
                            <x-std::avatar.group>
                                <x-std::avatar name="Ada Lovelace" circle color="violet" />
                                <x-std::avatar name="Grace Hopper" circle color="blue" />
                                <x-std::avatar name="Alan Turing" circle color="green" />
                            </x-std::avatar.group>
                            <x-std::text size="sm" variant="subtle">3 organizers</x-std::text>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <x-std::dialog.trigger name="showcase-command">
                            <x-std::button variant="outline" class="gap-2 text-zinc-500 dark:text-zinc-400">
                                <x-std::icon name="search" class="size-4" />
                                <span class="hidden sm:inline">Search commands…</span>
                                <span class="rounded border border-zinc-200 px-1.5 py-0.5 font-mono text-[10px] tracking-widest dark:border-zinc-700">
                                    ⌘K
                                </span>
                            </x-std::button>
                        </x-std::dialog.trigger>

                        <x-std::tooltip side="bottom">
                            <x-std::tooltip.trigger>
                                <x-std::button variant="outline" square aria-label="Preview public page">
                                    <x-std::icon name="eye" class="size-4" />
                                </x-std::button>
                            </x-std::tooltip.trigger>
                            <x-std::tooltip.content>Preview public page</x-std::tooltip.content>
                        </x-std::tooltip>

                        <x-std::dropdown-menu align="end">
                            <x-std::dropdown-menu.trigger>
                                <x-std::button variant="outline">
                                    More
                                    <x-slot:trailing>
                                        <x-std::icon name="chevron-down" class="size-4 opacity-60" />
                                    </x-slot:trailing>
                                </x-std::button>
                            </x-std::dropdown-menu.trigger>
                            <x-std::dropdown-menu.content>
                                <x-std::dropdown-menu.label>Event</x-std::dropdown-menu.label>
                                <x-std::dropdown-menu.item>
                                    Duplicate
                                    <x-std::dropdown-menu.shortcut>⌘D</x-std::dropdown-menu.shortcut>
                                </x-std::dropdown-menu.item>
                                <x-std::dropdown-menu.item>
                                    Export CSV
                                    <x-std::dropdown-menu.shortcut>⌘E</x-std::dropdown-menu.shortcut>
                                </x-std::dropdown-menu.item>
                                <x-std::dropdown-menu.separator />
                                <x-std::dropdown-menu.item variant="danger"> Archive event </x-std::dropdown-menu.item>
                            </x-std::dropdown-menu.content>
                        </x-std::dropdown-menu>

                        <x-std::dialog>
                            <x-std::dialog.trigger>
                                <x-std::button variant="primary">Publish event</x-std::button>
                            </x-std::dialog.trigger>
                            <x-std::dialog.content>
                                <x-std::dialog.header>
                                    <x-std::dialog.title>Publish Northwind Summit?</x-std::dialog.title>
                                    <x-std::dialog.description>
                                        The public page goes live and ticket sales open immediately.
                                    </x-std::dialog.description>
                                </x-std::dialog.header>
                                <div class="mt-4 space-y-3">
                                    <x-std::field name="publish_note">
                                        <x-std::field.label>Release note</x-std::field.label>
                                        <x-std::input name="publish_note" placeholder="What changed for attendees?" />
                                        <x-std::field.description>
                                            Shown once in the organizer activity feed.</x-std::field.description>
                                    </x-std::field>
                                </div>
                                <x-std::dialog.footer>
                                    <x-std::dialog.cancel>Keep drafting</x-std::dialog.cancel>
                                    <x-std::dialog.action variant="primary">Publish now</x-std::dialog.action>
                                </x-std::dialog.footer>
                            </x-std::dialog.content>
                        </x-std::dialog>
                    </div>
                </x-std::header>

                <x-std::command.dialog name="showcase-command" shortcut="meta.k">
                    <x-std::command placeholder="Type a command or search…">
                        <x-std::command.group heading="Navigation">
                            <x-std::command.item value="details">Jump to details</x-std::command.item>
                            <x-std::command.item value="schedule">Jump to schedule</x-std::command.item>
                            <x-std::command.item value="guests">Jump to guests</x-std::command.item>
                            <x-std::command.item value="insights">Jump to insights</x-std::command.item>
                            <x-std::command.item value="settings">Jump to settings</x-std::command.item>
                        </x-std::command.group>
                        <x-std::command.separator />
                        <x-std::command.group heading="Actions">
                            <x-std::command.item value="publish" kbd="⌘P">Publish event</x-std::command.item>
                            <x-std::command.item value="duplicate" kbd="⌘D">Duplicate event</x-std::command.item>
                            <x-std::command.item value="export" kbd="⌘E">Export registrations</x-std::command.item>
                        </x-std::command.group>
                    </x-std::command>
                </x-std::command.dialog>

                {{-- Status strip --}}
                <div class="space-y-3">
                    <x-std::alert variant="warning" icon="clipboard">
                        <x-std::text class="leading-none font-medium tracking-tight">
                            Finish setup before publishing
                        </x-std::text>
                        <x-std::alert.description>
                            Add at least one ticket tier and confirm the venue capacity. Your public page stays gated
                            until then.
                        </x-std::alert.description>
                    </x-std::alert>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between gap-3" id="setup-progress-label">
                            <x-std::text size="sm" variant="subtle">Setup progress</x-std::text>
                            <x-std::text size="sm" class="font-medium tabular-nums">72%</x-std::text>
                        </div>
                        <x-std::progress :value="72" aria-labelledby="setup-progress-label" />
                    </div>
                </div>

                <x-std::grid md="3" gap="4">
                    <x-std::stat
                        label="Registrations"
                        value="248"
                        trend="+12.4%"
                        trend-direction="up"
                        description="vs last 7 days"
                        icon="file"
                    />
                    <x-std::stat
                        label="Revenue"
                        value="R$ 46.8k"
                        trend="+8.2%"
                        trend-direction="up"
                        description="Ticket sales"
                        icon="clock"
                    />
                    <x-std::stat
                        label="Check-in rate"
                        value="64%"
                        trend="−2.1%"
                        trend-direction="down"
                        description="Doors open day one"
                        icon="check"
                    />
                </x-std::grid>

                <x-std::separator />

                {{-- Main workspace --}}
                <form action="#" method="post" class="space-y-6" onsubmit="return false;">
                    @csrf

                    <x-std::tabs default-value="details" variant="line">
                        <x-std::tabs.list>
                            <x-std::tabs.trigger value="details">Details</x-std::tabs.trigger>
                            <x-std::tabs.trigger value="schedule">Schedule</x-std::tabs.trigger>
                            <x-std::tabs.trigger value="guests">Guests</x-std::tabs.trigger>
                            <x-std::tabs.trigger value="insights">Insights</x-std::tabs.trigger>
                            <x-std::tabs.trigger value="settings">Settings</x-std::tabs.trigger>
                        </x-std::tabs.list>

                        {{-- Details --}}
                        <x-std::tabs.content value="details" class="mt-6!" id="details">
                            <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_18rem]">
                                <div class="space-y-6">
                                    <x-std::heading :level="2" class="sr-only">Details</x-std::heading>
                                    <x-std::card>
                                        <x-std::card.header>
                                            <x-std::card.title>Event profile</x-std::card.title>
                                            <x-std::card.description>
                                                Basics shown on the public landing page and tickets.
                                            </x-std::card.description>
                                        </x-std::card.header>
                                        <x-std::card.content class="space-y-5">
                                            <x-std::field name="title">
                                                <x-std::field.label :required="true">Title</x-std::field.label>
                                                <x-std::input name="title" value="Northwind Summit 2026" />
                                            </x-std::field>

                                            <x-std::field name="slug">
                                                <x-std::label for="slug">Public URL</x-std::label>
                                                <x-std::input
                                                    id="slug"
                                                    name="slug"
                                                    prefix="https://"
                                                    suffix=".events.test"
                                                    value="northwind-summit"
                                                />
                                                <x-std::field.description>
                                                    Lowercase letters, numbers, and hyphens.</x-std::field.description>
                                            </x-std::field>

                                            <x-std::field name="summary">
                                                <x-std::field.label>Summary</x-std::field.label>
                                                <x-std::textarea
                                                    name="summary"
                                                    rows="3"
                                                    placeholder="One short paragraph for search results and invites…"
                                                    >Two days of talks, workshops, and hallway track for Laravel teams
                                                    shipping Blade UIs.</x-std::textarea>
                                            </x-std::field>

                                            <x-std::field name="highlight" orientation="inline">
                                                <x-std::toggle
                                                    name="highlight"
                                                    :pressed="true"
                                                    aria-label="Highlight on public page"
                                                >
                                                    Highlight on public page
                                                </x-std::toggle>
                                            </x-std::field>

                                            <x-std::grid sm="2" gap="5">
                                                <x-std::field name="format">
                                                    <x-std::field.label>Format</x-std::field.label>
                                                    <x-std::select name="format" placeholder="Choose format…">
                                                        <x-std::select.group>
                                                            <x-std::select.label>In person</x-std::select.label>
                                                            <x-std::select.item value="conference">
                                                                Conference</x-std::select.item>
                                                            <x-std::select.item value="workshop">
                                                                Workshop</x-std::select.item>
                                                        </x-std::select.group>
                                                        <x-std::select.separator />
                                                        <x-std::select.item value="hybrid">Hybrid</x-std::select.item>
                                                        <x-std::select.item value="online">
                                                            Online only</x-std::select.item>
                                                    </x-std::select>
                                                </x-std::field>

                                                <x-std::field name="venue_city">
                                                    <x-std::field.label>City</x-std::field.label>
                                                    <x-std::combobox
                                                        name="venue_city"
                                                        placeholder="Search cities…"
                                                        value="porto-alegre"
                                                    >
                                                        <x-std::combobox.group>
                                                            <x-std::combobox.label>Brazil</x-std::combobox.label>
                                                            <x-std::combobox.item value="porto-alegre">
                                                                Porto Alegre</x-std::combobox.item>
                                                            <x-std::combobox.item value="sao-paulo">
                                                                São Paulo</x-std::combobox.item>
                                                            <x-std::combobox.item value="curitiba">
                                                                Curitiba</x-std::combobox.item>
                                                        </x-std::combobox.group>
                                                        <x-std::combobox.separator />
                                                        <x-std::combobox.group>
                                                            <x-std::combobox.label>Elsewhere</x-std::combobox.label>
                                                            <x-std::combobox.item value="lisbon">
                                                                Lisbon</x-std::combobox.item>
                                                            <x-std::combobox.item value="berlin">
                                                                Berlin</x-std::combobox.item>
                                                        </x-std::combobox.group>
                                                    </x-std::combobox>
                                                </x-std::field>
                                            </x-std::grid>

                                            <x-std::field name="tags">
                                                <x-std::field.label>Topics</x-std::field.label>
                                                <x-std::pillbox
                                                    name="tags"
                                                    :value="['laravel', 'blade', 'accessibility']"
                                                    placeholder="Add a topic…"
                                                />
                                            </x-std::field>

                                            <x-std::field name="brand_color">
                                                <x-std::field.label>Brand color</x-std::field.label>
                                                <x-std::color-picker
                                                    name="brand_color"
                                                    value="#0f766e"
                                                    class="max-w-xs"
                                                />
                                            </x-std::field>

                                            <x-std::field name="cover">
                                                <x-std::field.label>Cover image</x-std::field.label>
                                                <x-std::file-upload
                                                    name="cover"
                                                    accept="image/*"
                                                    text="PNG or JPG up to 5MB"
                                                />
                                            </x-std::field>
                                        </x-std::card.content>
                                        <x-std::card.footer class="flex flex-wrap justify-end gap-2">
                                            <x-std::button type="button" variant="ghost">Discard</x-std::button>
                                            <x-std::button type="submit" variant="primary">Save details</x-std::button>
                                        </x-std::card.footer>
                                    </x-std::card>

                                    <x-std::card>
                                        <x-std::card.header>
                                            <x-std::card.title>Ticketing</x-std::card.title>
                                            <x-std::card.description>
                                                Capacity, price range, and visibility.</x-std::card.description>
                                        </x-std::card.header>
                                        <x-std::card.content class="space-y-5">
                                            <x-std::radio.group name="access" legend="Access model">
                                                <x-std::radio value="free">Free RSVP</x-std::radio>
                                                <x-std::radio value="paid" :checked="true">Paid tickets</x-std::radio>
                                                <x-std::radio value="invite">Invite only</x-std::radio>
                                            </x-std::radio.group>

                                            <x-std::field name="base_price">
                                                <x-std::field.label>Early-bird price</x-std::field.label>
                                                <x-std::input.currency
                                                    name="base_price"
                                                    :value="189.0"
                                                    currency="BRL"
                                                    locale="pt_BR"
                                                    :precision="2"
                                                    placeholder="0,00"
                                                    class="max-w-xs"
                                                />
                                            </x-std::field>

                                            <x-std::field name="capacity">
                                                <x-std::field.label>Venue capacity</x-std::field.label>
                                                <x-std::slider
                                                    name="capacity"
                                                    :value="320"
                                                    :min="50"
                                                    :max="800"
                                                    class="max-w-md"
                                                />
                                                <x-std::field.description>
                                                    Soft cap for waitlist messaging.</x-std::field.description>
                                            </x-std::field>

                                            <x-std::field name="expected_score">
                                                <x-std::field.label>Internal readiness</x-std::field.label>
                                                <x-std::rating name="expected_score" :value="4" :max="5" />
                                            </x-std::field>

                                            <x-std::separator />

                                            <x-std::field name="waitlist" orientation="inline">
                                                <div class="flex min-w-0 flex-1 flex-col gap-1">
                                                    <x-std::field.label>Enable waitlist</x-std::field.label>
                                                    <x-std::field.description>
                                                        When capacity is reached.</x-std::field.description>
                                                </div>
                                                <x-std::switch name="waitlist" :checked="true" />
                                            </x-std::field>

                                            <x-std::field name="code_of_conduct" orientation="inline">
                                                <x-std::checkbox name="code_of_conduct" value="1" :checked="true" />
                                                <x-std::field.label>
                                                    Require code of conduct acknowledgment</x-std::field.label>
                                            </x-std::field>
                                        </x-std::card.content>
                                    </x-std::card>
                                </div>

                                <aside class="space-y-4" aria-label="Event sidebar">
                                    <div
                                        class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900/60"
                                        aria-busy="true"
                                        aria-live="polite"
                                    >
                                        <x-std::heading :level="3" class="text-base!">Live activity</x-std::heading>
                                        <x-std::text size="sm" variant="subtle" class="mt-1">Refreshing…</x-std::text>
                                        <div class="mt-4 space-y-4">
                                            <div class="flex items-center gap-3">
                                                <x-std::skeleton rounded="full" class="size-9" />
                                                <div class="flex-1 space-y-2">
                                                    <x-std::skeleton class="h-3 w-28" />
                                                    <x-std::skeleton class="h-3 w-40" />
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <x-std::skeleton rounded="full" class="size-9" />
                                                <div class="flex-1 space-y-2">
                                                    <x-std::skeleton class="h-3 w-24" />
                                                    <x-std::skeleton class="h-3 w-36" />
                                                </div>
                                            </div>
                                            <x-std::skeleton class="h-20 w-full rounded-lg" />
                                        </div>
                                    </div>

                                    <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900/60">
                                        <div class="flex items-center justify-between gap-2">
                                            <x-std::heading :level="3" class="text-base!">Quick filters</x-std::heading>
                                            <x-std::popover align="end" side="bottom">
                                                <x-std::popover.trigger>
                                                    <x-std::button type="button" variant="ghost" size="sm">
                                                        Filters
                                                    </x-std::button>
                                                </x-std::popover.trigger>
                                                <x-std::popover.content class="w-72">
                                                    <div class="space-y-3">
                                                        <x-std::field name="filter_track">
                                                            <x-std::field.label>Track</x-std::field.label>
                                                            <x-std::select
                                                                name="filter_track"
                                                                size="sm"
                                                                placeholder="Any track"
                                                            >
                                                                <x-std::select.item value="all">
                                                                    Any track</x-std::select.item>
                                                                <x-std::select.item value="core">
                                                                    Core</x-std::select.item>
                                                                <x-std::select.item value="ui">UI</x-std::select.item>
                                                            </x-std::select>
                                                        </x-std::field>
                                                        <x-std::button
                                                            type="button"
                                                            variant="secondary"
                                                            size="sm"
                                                            class="w-full"
                                                            data-popover-close
                                                        >
                                                            Apply filters
                                                        </x-std::button>
                                                    </div>
                                                </x-std::popover.content>
                                            </x-std::popover>
                                        </div>
                                    </div>
                                </aside>
                            </div>
                        </x-std::tabs.content>

                        {{-- Schedule --}}
                        <x-std::tabs.content value="schedule" class="mt-6!" id="schedule">
                            <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_20rem]">
                                <div class="space-y-6">
                                    <x-std::heading :level="2" class="sr-only">Schedule</x-std::heading>
                                    <x-std::card>
                                        <x-std::card.header>
                                            <x-std::card.title>When &amp; where</x-std::card.title>
                                            <x-std::card.description>
                                                Date, doors, and kickoff datetime.</x-std::card.description>
                                        </x-std::card.header>
                                        <x-std::card.content>
                                            <x-std::grid sm="2" gap="5">
                                                <x-std::field name="event_date">
                                                    <x-std::field.label>Event date</x-std::field.label>
                                                    <x-std::date-picker
                                                        name="event_date"
                                                        value="2026-09-18"
                                                        with-today
                                                    />
                                                </x-std::field>

                                                <x-std::field name="doors_open">
                                                    <x-std::field.label>Doors open</x-std::field.label>
                                                    <x-std::time-picker name="doors_open" value="08:30" />
                                                </x-std::field>

                                                <x-std::grid.item span="full">
                                                    <x-std::field name="kickoff_at">
                                                        <x-std::field.label>Keynote starts</x-std::field.label>
                                                        <x-std::datetime-picker
                                                            name="kickoff_at"
                                                            value="2026-09-18T09:15"
                                                        />
                                                    </x-std::field>
                                                </x-std::grid.item>
                                            </x-std::grid>
                                        </x-std::card.content>
                                    </x-std::card>

                                    <x-std::card>
                                        <x-std::card.header>
                                            <x-std::card.title>Sessions</x-std::card.title>
                                            <x-std::card.description>
                                                Repeating rows for the day schedule.</x-std::card.description>
                                        </x-std::card.header>
                                        <x-std::card.content>
                                            <x-std::repeater
                                                name="sessions"
                                                :value="[
                                                    ['title' => 'Opening keynote', 'room' => 'Main hall'],
                                                    ['title' => 'Composable Blade panels', 'room' => 'Room B'],
                                                ]"
                                                :min="1"
                                                class="w-full"
                                            >
                                                <x-std::repeater.item>
                                                    <div class="grid gap-3 sm:grid-cols-2">
                                                        <x-std::input
                                                            data-repeater-field="title"
                                                            placeholder="Session title"
                                                        />
                                                        <x-std::input data-repeater-field="room" placeholder="Room" />
                                                    </div>
                                                    <x-std::repeater.remove />
                                                </x-std::repeater.item>
                                                <x-std::repeater.add>Add session</x-std::repeater.add>
                                            </x-std::repeater>
                                        </x-std::card.content>
                                    </x-std::card>
                                </div>

                                <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900/60">
                                    <x-std::heading :level="3" class="text-base!">Month view</x-std::heading>
                                    <x-std::text size="sm" variant="subtle" class="mt-1 mb-4">
                                        Standalone calendar for blocking hold dates.
                                    </x-std::text>
                                    <x-std::calendar name="hold_date" value="2026-09-18" with-today />
                                </div>
                            </div>
                        </x-std::tabs.content>

                        {{-- Guests --}}
                        <x-std::tabs.content value="guests" class="mt-6!" id="guests">
                            <div class="space-y-6">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                                    <div class="space-y-1">
                                        <x-std::heading :level="2" class="text-xl!">Registrations</x-std::heading>
                                        <x-std::text size="sm" variant="subtle">
                                            Latest ticket holders and check-in status.
                                        </x-std::text>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <x-std::toggle-group
                                            type="single"
                                            default-value="table"
                                            variant="outline"
                                            size="sm"
                                            aria-label="Guest list view"
                                        >
                                            <x-std::toggle-group.item value="table">Table</x-std::toggle-group.item>
                                            <x-std::toggle-group.item value="cards">Cards</x-std::toggle-group.item>
                                        </x-std::toggle-group>

                                        <x-std::button-group aria-label="Guest list actions">
                                            <x-std::button type="button" variant="outline" size="sm">
                                                <x-std::icon name="upload" class="size-4" />
                                                Import
                                            </x-std::button>
                                            <x-std::button-group.separator />
                                            <x-std::button type="button" variant="outline" size="sm">
                                                Export
                                            </x-std::button>
                                            <x-std::button type="button" variant="secondary" size="sm">
                                                Remind pending
                                            </x-std::button>
                                        </x-std::button-group>
                                    </div>
                                </div>

                                <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
                                    <x-std::table>
                                        <x-std::table.caption>Page 2 of recent registrations</x-std::table.caption>
                                        <x-std::table.header>
                                            <x-std::table.row>
                                                <x-std::table.head>Guest</x-std::table.head>
                                                <x-std::table.head>Ticket</x-std::table.head>
                                                <x-std::table.head>Status</x-std::table.head>
                                                <x-std::table.head class="text-right">Paid</x-std::table.head>
                                            </x-std::table.row>
                                        </x-std::table.header>
                                        <x-std::table.body>
                                            <x-std::table.row>
                                                <x-std::table.cell variant="strong">
                                                    <div class="flex items-center gap-3">
                                                        <x-std::avatar
                                                            name="Taylor Otwell"
                                                            size="sm"
                                                            circle
                                                            color="indigo"
                                                        />
                                                        Taylor Otwell
                                                    </div>
                                                </x-std::table.cell>
                                                <x-std::table.cell>Pro pass</x-std::table.cell>
                                                <x-std::table.cell>
                                                    <x-std::badge color="green" rounded>Checked in</x-std::badge>
                                                </x-std::table.cell>
                                                <x-std::table.cell class="text-right">R$ 189,00</x-std::table.cell>
                                            </x-std::table.row>
                                            <x-std::table.row>
                                                <x-std::table.cell variant="strong">
                                                    <div class="flex items-center gap-3">
                                                        <x-std::avatar
                                                            name="Nuno Maduro"
                                                            size="sm"
                                                            circle
                                                            color="rose"
                                                        />
                                                        Nuno Maduro
                                                    </div>
                                                </x-std::table.cell>
                                                <x-std::table.cell>Workshop</x-std::table.cell>
                                                <x-std::table.cell>
                                                    <x-std::badge color="amber" rounded>Pending</x-std::badge>
                                                </x-std::table.cell>
                                                <x-std::table.cell class="text-right">R$ 320,00</x-std::table.cell>
                                            </x-std::table.row>
                                            <x-std::table.row>
                                                <x-std::table.cell variant="strong">
                                                    <div class="flex items-center gap-3">
                                                        <x-std::avatar
                                                            name="Jess Archer"
                                                            size="sm"
                                                            circle
                                                            color="violet"
                                                        />
                                                        Jess Archer
                                                    </div>
                                                </x-std::table.cell>
                                                <x-std::table.cell>Community</x-std::table.cell>
                                                <x-std::table.cell>
                                                    <x-std::badge variant="outline" rounded>Refunded</x-std::badge>
                                                </x-std::table.cell>
                                                <x-std::table.cell class="text-right">R$ 0,00</x-std::table.cell>
                                            </x-std::table.row>
                                        </x-std::table.body>
                                    </x-std::table>
                                </div>

                                <x-std::pagination>
                                    <x-std::pagination.content>
                                        <x-std::pagination.item>
                                            <x-std::pagination.previous href="#guests" />
                                        </x-std::pagination.item>
                                        <x-std::pagination.item>
                                            <x-std::pagination.link href="#guests">1</x-std::pagination.link>
                                        </x-std::pagination.item>
                                        <x-std::pagination.item>
                                            <x-std::pagination.link href="#guests" :is-active="true">
                                                2</x-std::pagination.link>
                                        </x-std::pagination.item>
                                        <x-std::pagination.item>
                                            <x-std::pagination.link href="#guests">3</x-std::pagination.link>
                                        </x-std::pagination.item>
                                        <x-std::pagination.item>
                                            <x-std::pagination.ellipsis />
                                        </x-std::pagination.item>
                                        <x-std::pagination.item>
                                            <x-std::pagination.link href="#guests">12</x-std::pagination.link>
                                        </x-std::pagination.item>
                                        <x-std::pagination.item>
                                            <x-std::pagination.next href="#guests" />
                                        </x-std::pagination.item>
                                    </x-std::pagination.content>
                                </x-std::pagination>

                                <x-std::empty class="border border-zinc-200 dark:border-zinc-800">
                                    <x-std::empty.header>
                                        <x-std::empty.media variant="icon" icon="file" />
                                        <x-std::empty.title>No speakers on the waitlist</x-std::empty.title>
                                        <x-std::empty.description>
                                            Invite keynote candidates or open a public CFP to fill this list.
                                        </x-std::empty.description>
                                    </x-std::empty.header>
                                    <x-std::empty.content>
                                        <x-std::button type="button" variant="outline" size="sm">
                                            Open speaker CFP
                                        </x-std::button>
                                    </x-std::empty.content>
                                </x-std::empty>

                                <x-std::card>
                                    <x-std::card.header>
                                        <x-std::card.title>Door staff PIN</x-std::card.title>
                                        <x-std::card.description>
                                            Six-digit code for offline check-in devices.
                                        </x-std::card.description>
                                    </x-std::card.header>
                                    <x-std::card.content>
                                        <x-std::input-otp name="door_pin" />
                                    </x-std::card.content>
                                </x-std::card>
                            </div>
                        </x-std::tabs.content>

                        {{-- Insights --}}
                        <x-std::tabs.content value="insights" class="mt-6!" id="insights">
                            <div class="space-y-6">
                                <div class="space-y-1">
                                    <x-std::heading :level="2" class="text-xl!">Public page traffic</x-std::heading>
                                    <x-std::text size="sm" variant="subtle">
                                        Daily visitors on the Northwind Summit landing page.
                                    </x-std::text>
                                </div>

                                <x-std::chart
                                    :value="$insightsData"
                                    label="Daily visitors"
                                    class="aspect-[3/1] w-full max-w-4xl"
                                >
                                    <x-std::chart.svg>
                                        <x-std::chart.line field="visitors" class="text-[var(--chart-3)]" />
                                        <x-std::chart.point field="visitors" class="text-[var(--chart-3)]" />
                                        <x-std::chart.axis axis="x" field="date">
                                            <x-std::chart.axis.line />
                                            <x-std::chart.axis.tick />
                                        </x-std::chart.axis>
                                        <x-std::chart.axis axis="y">
                                            <x-std::chart.axis.grid />
                                            <x-std::chart.axis.tick />
                                        </x-std::chart.axis>
                                        <x-std::chart.cursor />
                                    </x-std::chart.svg>
                                    <x-std::chart.tooltip>
                                        <x-std::chart.tooltip.heading field="date" />
                                        <x-std::chart.tooltip.value field="visitors" label="Visitors" />
                                    </x-std::chart.tooltip>
                                </x-std::chart>
                            </div>
                        </x-std::tabs.content>

                        {{-- Settings --}}
                        <x-std::tabs.content value="settings" class="mt-6!" id="settings">
                            <div class="mx-auto max-w-2xl space-y-6">
                                <x-std::heading :level="2" class="sr-only">Settings</x-std::heading>

                                <x-std::card>
                                    <x-std::card.header>
                                        <x-std::card.title>Publish checklist</x-std::card.title>
                                        <x-std::card.description>
                                            Walk through setup before going live.</x-std::card.description>
                                    </x-std::card.header>
                                    <x-std::card.content>
                                        <x-std::stepper
                                            default-value="profile"
                                            stepper-id="showcase-publish-stepper"
                                            :linear="true"
                                        >
                                            <x-std::stepper.list>
                                                <x-std::stepper.item value="profile" :step="1">
                                                    <x-std::stepper.trigger>
                                                        <x-std::stepper.indicator />
                                                        <x-std::stepper.label>
                                                            <x-std::stepper.title>Profile</x-std::stepper.title>
                                                            <x-std::stepper.description>
                                                                Event details complete</x-std::stepper.description>
                                                        </x-std::stepper.label>
                                                    </x-std::stepper.trigger>
                                                    <x-std::stepper.separator />
                                                </x-std::stepper.item>
                                                <x-std::stepper.item value="tickets" :step="2">
                                                    <x-std::stepper.trigger>
                                                        <x-std::stepper.indicator />
                                                        <x-std::stepper.label>
                                                            <x-std::stepper.title>Tickets</x-std::stepper.title>
                                                            <x-std::stepper.description>
                                                                Pricing and capacity</x-std::stepper.description>
                                                        </x-std::stepper.label>
                                                    </x-std::stepper.trigger>
                                                    <x-std::stepper.separator />
                                                </x-std::stepper.item>
                                                <x-std::stepper.item value="review" :step="3">
                                                    <x-std::stepper.trigger>
                                                        <x-std::stepper.indicator />
                                                        <x-std::stepper.label>
                                                            <x-std::stepper.title>Review</x-std::stepper.title>
                                                            <x-std::stepper.description>
                                                                Final publish check</x-std::stepper.description>
                                                        </x-std::stepper.label>
                                                    </x-std::stepper.trigger>
                                                </x-std::stepper.item>
                                            </x-std::stepper.list>

                                            <div class="mt-6 space-y-4">
                                                <x-std::stepper.content value="profile">
                                                    Confirm the public title, summary, and cover image are ready.
                                                </x-std::stepper.content>
                                                <x-std::stepper.content value="tickets">
                                                    Set at least one ticket tier and venue capacity.
                                                </x-std::stepper.content>
                                                <x-std::stepper.content value="review">
                                                    Review the public page preview, then publish when ready.
                                                </x-std::stepper.content>

                                                <x-std::stepper.navigation>
                                                    <x-std::stepper.previous />
                                                    <x-std::stepper.next />
                                                </x-std::stepper.navigation>
                                            </div>
                                        </x-std::stepper>
                                    </x-std::card.content>
                                </x-std::card>

                                <x-std::card>
                                    <x-std::card.header>
                                        <x-std::card.title>Advanced</x-std::card.title>
                                        <x-std::card.description>
                                            Optional tooling most organizers leave closed.</x-std::card.description>
                                    </x-std::card.header>
                                    <x-std::card.content class="space-y-4">
                                        <x-std::collapsible>
                                            <x-std::collapsible.trigger>
                                                Webhook &amp; integrations</x-std::collapsible.trigger>
                                            <x-std::collapsible.content class="mt-3 space-y-4">
                                                <x-std::field name="webhook_url">
                                                    <x-std::field.label>Webhook URL</x-std::field.label>
                                                    <x-std::input
                                                        name="webhook_url"
                                                        type="url"
                                                        placeholder="https://hooks.example.test/events"
                                                    />
                                                </x-std::field>
                                                <x-std::alert variant="info" icon="clipboard">
                                                    <x-std::text class="leading-none font-medium tracking-tight">
                                                        Tip</x-std::text>
                                                    <x-std::alert.description>
                                                        We retry failed deliveries for 24 hours with exponential
                                                        backoff.
                                                    </x-std::alert.description>
                                                </x-std::alert>
                                            </x-std::collapsible.content>
                                        </x-std::collapsible>

                                        <x-std::separator />

                                        <x-std::accordion exclusive bordered>
                                            <x-std::accordion.item value="refunds" :expanded="true">
                                                <x-std::accordion.trigger>
                                                    What is the refund policy?</x-std::accordion.trigger>
                                                <x-std::accordion.content>
                                                    Full refunds until 14 days before the event. After that, tickets
                                                    convert to credit for next year.
                                                </x-std::accordion.content>
                                            </x-std::accordion.item>
                                            <x-std::accordion.item heading="Can I transfer a ticket?">
                                                Yes — transfers stay open until doors open on day one.
                                            </x-std::accordion.item>
                                            <x-std::accordion.item heading="How do speakers get access?">
                                                Speakers receive a complimentary Pro pass and a private green-room link.
                                            </x-std::accordion.item>
                                        </x-std::accordion>
                                    </x-std::card.content>
                                    <x-std::card.footer class="flex flex-wrap items-center justify-between gap-3">
                                        <x-std::dialog>
                                            <x-std::dialog.trigger>
                                                <x-std::button type="button" variant="danger"
                                                    >Cancel event</x-std::button>
                                            </x-std::dialog.trigger>
                                            <x-std::dialog.content alert>
                                                <x-std::dialog.header>
                                                    <x-std::dialog.title>Cancel this event?</x-std::dialog.title>
                                                    <x-std::dialog.description>
                                                        Guests are emailed automatically. This cannot be undone from the
                                                        UI.
                                                    </x-std::dialog.description>
                                                </x-std::dialog.header>
                                                <x-std::dialog.footer>
                                                    <x-std::dialog.cancel>Keep event</x-std::dialog.cancel>
                                                    <x-std::dialog.action variant="danger">
                                                        Cancel event</x-std::dialog.action>
                                                </x-std::dialog.footer>
                                            </x-std::dialog.content>
                                        </x-std::dialog>

                                        <x-std::button type="submit" variant="primary">Save settings</x-std::button>
                                    </x-std::card.footer>
                                </x-std::card>
                            </div>
                        </x-std::tabs.content>
                    </x-std::tabs>
                </form>
            </x-std::main>
        </x-std::sidebar.inset>
    </x-std::sidebar.provider>
@endsection
