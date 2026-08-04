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
    @php
        $insightsData = [
            ['date' => '2026-07-28', 'visitors' => 241],
            ['date' => '2026-07-29', 'visitors' => 259],
            ['date' => '2026-07-30', 'visitors' => 269],
            ['date' => '2026-07-31', 'visitors' => 259],
            ['date' => '2026-08-01', 'visitors' => 267],
        ];
    @endphp

    <x-ui::toast.provider position="bottom-right">
        <x-ui::toast
            variant="success"
            title="Draft autosaved"
            description="Northwind Summit was saved a moment ago."
            :duration="8000"
        />
    </x-ui::toast.provider>

    <x-ui::sidebar.provider
        :default-open="true"
        storage-key="stencil-showcase-sidebar"
        class="h-svh"
        id="playbook-main"
    >
        <x-ui::sidebar collapsible="icon" class="shrink-0">
            <x-ui::sidebar.header>
                <x-ui::sidebar.menu>
                    <x-ui::sidebar.menu-item>
                        <x-ui::dropdown-menu side="right" align="start">
                            <x-ui::dropdown-menu.trigger>
                                <x-ui::sidebar.menu-button
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
                                    <x-ui::icon
                                        name="chevron-down"
                                        class="ml-auto size-4 group-data-[collapsible=icon]:hidden"
                                    />
                                </x-ui::sidebar.menu-button>
                            </x-ui::dropdown-menu.trigger>
                            <x-ui::dropdown-menu.content class="min-w-56">
                                <x-ui::dropdown-menu.label>Switch workspace</x-ui::dropdown-menu.label>
                                <x-ui::dropdown-menu.item href="{{ route('playbook.index') }}">
                                    Stencil Playbook
                                </x-ui::dropdown-menu.item>
                                <x-ui::dropdown-menu.item href="{{ route('playbook.showcase') }}">
                                    Event Studio
                                </x-ui::dropdown-menu.item>
                            </x-ui::dropdown-menu.content>
                        </x-ui::dropdown-menu>
                    </x-ui::sidebar.menu-item>
                </x-ui::sidebar.menu>
            </x-ui::sidebar.header>

            <x-ui::sidebar.content>
                <x-ui::sidebar.group>
                    <x-ui::sidebar.group-label>Events</x-ui::sidebar.group-label>
                    <x-ui::sidebar.group-content>
                        <x-ui::sidebar.menu>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button
                                    href="{{ route('playbook.showcase') }}"
                                    active
                                    tooltip="Northwind Summit"
                                >
                                    <x-ui::icon name="star" class="size-4" />
                                    <span>Northwind Summit</span>
                                </x-ui::sidebar.menu-button>
                                <x-ui::sidebar.menu-badge>72%</x-ui::sidebar.menu-badge>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#" tooltip="Laravel Day SP">
                                    <x-ui::icon name="calendar" class="size-4" />
                                    <span>Laravel Day SP</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                        </x-ui::sidebar.menu>
                    </x-ui::sidebar.group-content>
                </x-ui::sidebar.group>

                <x-ui::sidebar.group>
                    <x-ui::sidebar.group-label>Projects</x-ui::sidebar.group-label>
                    <x-ui::sidebar.group-content>
                        <x-ui::sidebar.menu>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#details" tooltip="Event profile">
                                    <x-ui::icon name="clipboard" class="size-4" />
                                    <span>Event profile</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#schedule" tooltip="Schedule build">
                                    <x-ui::icon name="calendar" class="size-4" />
                                    <span>Schedule build</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#guests" tooltip="Guest operations">
                                    <x-ui::icon name="eye" class="size-4" />
                                    <span>Guest operations</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="{{ route('playbook.index') }}" tooltip="More">
                                    <x-ui::icon name="plus" class="size-4" />
                                    <span>More</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                        </x-ui::sidebar.menu>
                    </x-ui::sidebar.group-content>
                </x-ui::sidebar.group>

                <x-ui::sidebar.separator />

                <x-ui::sidebar.group>
                    <x-ui::sidebar.group-label>Workspace</x-ui::sidebar.group-label>
                    <x-ui::sidebar.group-content>
                        <x-ui::sidebar.menu>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#details" tooltip="Details">
                                    <x-ui::icon name="file" class="size-4" />
                                    <span>Details</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#schedule" tooltip="Schedule">
                                    <x-ui::icon name="calendar" class="size-4" />
                                    <span>Schedule</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#guests" tooltip="Guests">
                                    <x-ui::icon name="clipboard" class="size-4" />
                                    <span>Guests</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#insights" tooltip="Insights">
                                    <x-ui::icon name="eye" class="size-4" />
                                    <span>Insights</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-item>
                                <x-ui::sidebar.menu-button href="#settings" tooltip="Settings">
                                    <x-ui::icon name="star" class="size-4" />
                                    <span>Settings</span>
                                </x-ui::sidebar.menu-button>
                            </x-ui::sidebar.menu-item>
                        </x-ui::sidebar.menu>
                    </x-ui::sidebar.group-content>
                </x-ui::sidebar.group>
            </x-ui::sidebar.content>

            <x-ui::sidebar.footer>
                <x-ui::sidebar.menu>
                    <x-ui::sidebar.menu-item>
                        <x-ui::dropdown-menu side="top" align="start">
                            <x-ui::dropdown-menu.trigger>
                                <x-ui::sidebar.menu-button
                                    size="lg"
                                    class="data-[state=open]:bg-zinc-100 dark:data-[state=open]:bg-zinc-800"
                                >
                                    <x-ui::avatar name="Ada Lovelace" size="sm" circle color="violet" />
                                    <div class="grid flex-1 text-left text-sm leading-tight group-data-[collapsible=icon]:hidden">
                                        <span class="truncate font-semibold">Ada Lovelace</span>
                                        <span class="truncate text-xs text-zinc-500 dark:text-zinc-400">organizer@northwind.dev</span>
                                    </div>
                                    <x-ui::icon
                                        name="chevron-down"
                                        class="ml-auto size-4 group-data-[collapsible=icon]:hidden"
                                    />
                                </x-ui::sidebar.menu-button>
                            </x-ui::dropdown-menu.trigger>
                            <x-ui::dropdown-menu.content class="min-w-56">
                                <x-ui::dropdown-menu.label>Appearance</x-ui::dropdown-menu.label>
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
                                <x-ui::dropdown-menu.separator />
                                <x-ui::dropdown-menu.item href="{{ route('playbook.index') }}">
                                    Back to Playbook
                                </x-ui::dropdown-menu.item>
                            </x-ui::dropdown-menu.content>
                        </x-ui::dropdown-menu>
                    </x-ui::sidebar.menu-item>
                </x-ui::sidebar.menu>
            </x-ui::sidebar.footer>

            <x-ui::sidebar.rail />
        </x-ui::sidebar>

        <x-ui::sidebar.inset>
            <x-ui::header>
                <div class="flex w-full items-center gap-2 px-4">
                    <x-ui::sidebar.trigger />
                    <x-ui::separator orientation="vertical" class="me-2 h-4!" />
                    <x-ui::breadcrumb>
                        <x-ui::breadcrumb.list>
                            <x-ui::breadcrumb.item class="hidden md:block">
                                <x-ui::breadcrumb.link href="{{ route('playbook.index') }}">
                                    Build your application
                                </x-ui::breadcrumb.link>
                            </x-ui::breadcrumb.item>
                            <x-ui::breadcrumb.separator class="hidden md:block" />
                            <x-ui::breadcrumb.item>
                                <x-ui::breadcrumb.page>Northwind Summit</x-ui::breadcrumb.page>
                            </x-ui::breadcrumb.item>
                        </x-ui::breadcrumb.list>
                    </x-ui::breadcrumb>
                </div>
            </x-ui::header>

            <x-ui::main class="gap-8">
                <x-ui::header variant="page" :border="false">
                    <div class="min-w-0 space-y-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <x-ui::heading :level="1">Northwind Summit 2026</x-ui::heading>
                            <x-ui::badge color="amber" rounded>Draft</x-ui::badge>
                            <x-ui::badge variant="outline" rounded>Public page</x-ui::badge>
                        </div>
                        <x-ui::text variant="subtle" class="max-w-prose">
                            Real-world composition of Stencil components — an event editor an organizer would actually
                            use. Illustrative data only.
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
                        <x-ui::dialog.trigger name="showcase-command">
                            <x-ui::button variant="outline" class="gap-2 text-zinc-500 dark:text-zinc-400">
                                <x-ui::icon name="search" class="size-4" />
                                <span class="hidden sm:inline">Search commands…</span>
                                <span class="rounded border border-zinc-200 px-1.5 py-0.5 font-mono text-[10px] tracking-widest dark:border-zinc-700">
                                    ⌘K
                                </span>
                            </x-ui::button>
                        </x-ui::dialog.trigger>

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
                                    <x-slot:trailing>
                                        <x-ui::icon name="chevron-down" class="size-4 opacity-60" />
                                    </x-slot:trailing>
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
                </x-ui::header>

                <x-ui::command.dialog name="showcase-command" shortcut="meta.k">
                    <x-ui::command placeholder="Type a command or search…">
                        <x-ui::command.group heading="Navigation">
                            <x-ui::command.item value="details">Jump to details</x-ui::command.item>
                            <x-ui::command.item value="schedule">Jump to schedule</x-ui::command.item>
                            <x-ui::command.item value="guests">Jump to guests</x-ui::command.item>
                            <x-ui::command.item value="insights">Jump to insights</x-ui::command.item>
                            <x-ui::command.item value="settings">Jump to settings</x-ui::command.item>
                        </x-ui::command.group>
                        <x-ui::command.separator />
                        <x-ui::command.group heading="Actions">
                            <x-ui::command.item value="publish" kbd="⌘P">Publish event</x-ui::command.item>
                            <x-ui::command.item value="duplicate" kbd="⌘D">Duplicate event</x-ui::command.item>
                            <x-ui::command.item value="export" kbd="⌘E">Export registrations</x-ui::command.item>
                        </x-ui::command.group>
                    </x-ui::command>
                </x-ui::command.dialog>

                {{-- Status strip --}}
                <div class="space-y-3">
                    <x-ui::alert variant="warning" icon="clipboard">
                        <x-ui::text class="leading-none font-medium tracking-tight">
                            Finish setup before publishing
                        </x-ui::text>
                        <x-ui::alert.description>
                            Add at least one ticket tier and confirm the venue capacity. Your public page stays gated
                            until then.
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

                <x-ui::grid md="3" gap="4">
                    <x-ui::stat
                        label="Registrations"
                        value="248"
                        trend="+12.4%"
                        trend-direction="up"
                        description="vs last 7 days"
                        icon="file"
                    />
                    <x-ui::stat
                        label="Revenue"
                        value="R$ 46.8k"
                        trend="+8.2%"
                        trend-direction="up"
                        description="Ticket sales"
                        icon="clock"
                    />
                    <x-ui::stat
                        label="Check-in rate"
                        value="64%"
                        trend="−2.1%"
                        trend-direction="down"
                        description="Doors open day one"
                        icon="check"
                    />
                </x-ui::grid>

                <x-ui::separator />

                {{-- Main workspace --}}
                <form action="#" method="post" class="space-y-6" onsubmit="return false;">
                    @csrf

                    <x-ui::tabs default-value="details" variant="line">
                        <x-ui::tabs.list>
                            <x-ui::tabs.trigger value="details">Details</x-ui::tabs.trigger>
                            <x-ui::tabs.trigger value="schedule">Schedule</x-ui::tabs.trigger>
                            <x-ui::tabs.trigger value="guests">Guests</x-ui::tabs.trigger>
                            <x-ui::tabs.trigger value="insights">Insights</x-ui::tabs.trigger>
                            <x-ui::tabs.trigger value="settings">Settings</x-ui::tabs.trigger>
                        </x-ui::tabs.list>

                        {{-- Details --}}
                        <x-ui::tabs.content value="details" class="mt-6!" id="details">
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
                                                    >Two days of talks, workshops, and hallway track for Laravel teams
                                                    shipping Blade UIs.</x-ui::textarea>
                                            </x-ui::field>

                                            <x-ui::field name="highlight" orientation="inline">
                                                <x-ui::toggle
                                                    name="highlight"
                                                    :pressed="true"
                                                    aria-label="Highlight on public page"
                                                >
                                                    Highlight on public page
                                                </x-ui::toggle>
                                            </x-ui::field>

                                            <x-ui::grid sm="2" gap="5">
                                                <x-ui::field name="format">
                                                    <x-ui::field.label>Format</x-ui::field.label>
                                                    <x-ui::select name="format" placeholder="Choose format…">
                                                        <x-ui::select.group>
                                                            <x-ui::select.label>In person</x-ui::select.label>
                                                            <x-ui::select.item value="conference">
                                                                Conference</x-ui::select.item>
                                                            <x-ui::select.item value="workshop">
                                                                Workshop</x-ui::select.item>
                                                        </x-ui::select.group>
                                                        <x-ui::select.separator />
                                                        <x-ui::select.item value="hybrid">Hybrid</x-ui::select.item>
                                                        <x-ui::select.item value="online">
                                                            Online only</x-ui::select.item>
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
                                                            <x-ui::combobox.item value="lisbon">
                                                                Lisbon</x-ui::combobox.item>
                                                            <x-ui::combobox.item value="berlin">
                                                                Berlin</x-ui::combobox.item>
                                                        </x-ui::combobox.group>
                                                    </x-ui::combobox>
                                                </x-ui::field>
                                            </x-ui::grid>

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
                                                <x-ui::color-picker
                                                    name="brand_color"
                                                    value="#0f766e"
                                                    class="max-w-xs"
                                                />
                                            </x-ui::field>

                                            <x-ui::field name="cover">
                                                <x-ui::field.label>Cover image</x-ui::field.label>
                                                <x-ui::file-upload
                                                    name="cover"
                                                    accept="image/*"
                                                    text="PNG or JPG up to 5MB"
                                                />
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
                                                <x-ui::field.label>
                                                    Require code of conduct acknowledgment</x-ui::field.label>
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
                                                            <x-ui::select
                                                                name="filter_track"
                                                                size="sm"
                                                                placeholder="Any track"
                                                            >
                                                                <x-ui::select.item value="all">
                                                                    Any track</x-ui::select.item>
                                                                <x-ui::select.item value="core">
                                                                    Core</x-ui::select.item>
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
                        <x-ui::tabs.content value="schedule" class="mt-6!" id="schedule">
                            <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_20rem]">
                                <div class="space-y-6">
                                    <x-ui::heading :level="2" class="sr-only">Schedule</x-ui::heading>
                                    <x-ui::card>
                                        <x-ui::card.header>
                                            <x-ui::card.title>When &amp; where</x-ui::card.title>
                                            <x-ui::card.description>
                                                Date, doors, and kickoff datetime.</x-ui::card.description>
                                        </x-ui::card.header>
                                        <x-ui::card.content>
                                            <x-ui::grid sm="2" gap="5">
                                                <x-ui::field name="event_date">
                                                    <x-ui::field.label>Event date</x-ui::field.label>
                                                    <x-ui::date-picker
                                                        name="event_date"
                                                        value="2026-09-18"
                                                        with-today
                                                    />
                                                </x-ui::field>

                                                <x-ui::field name="doors_open">
                                                    <x-ui::field.label>Doors open</x-ui::field.label>
                                                    <x-ui::time-picker name="doors_open" value="08:30" />
                                                </x-ui::field>

                                                <x-ui::grid.item span="full">
                                                    <x-ui::field name="kickoff_at">
                                                        <x-ui::field.label>Keynote starts</x-ui::field.label>
                                                        <x-ui::datetime-picker
                                                            name="kickoff_at"
                                                            value="2026-09-18T09:15"
                                                        />
                                                    </x-ui::field>
                                                </x-ui::grid.item>
                                            </x-ui::grid>
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
                                                        <x-ui::input
                                                            data-repeater-field="title"
                                                            placeholder="Session title"
                                                        />
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
                                    <div class="flex flex-wrap items-center gap-3">
                                        <x-ui::toggle-group
                                            type="single"
                                            default-value="table"
                                            variant="outline"
                                            size="sm"
                                            aria-label="Guest list view"
                                        >
                                            <x-ui::toggle-group.item value="table">Table</x-ui::toggle-group.item>
                                            <x-ui::toggle-group.item value="cards">Cards</x-ui::toggle-group.item>
                                        </x-ui::toggle-group>

                                        <x-ui::button-group aria-label="Guest list actions">
                                            <x-ui::button type="button" variant="outline" size="sm">
                                                <x-ui::icon name="upload" class="size-4" />
                                                Import
                                            </x-ui::button>
                                            <x-ui::button-group.separator />
                                            <x-ui::button type="button" variant="outline" size="sm">
                                                Export
                                            </x-ui::button>
                                            <x-ui::button type="button" variant="secondary" size="sm">
                                                Remind pending
                                            </x-ui::button>
                                        </x-ui::button-group>
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
                                                        <x-ui::avatar
                                                            name="Taylor Otwell"
                                                            size="sm"
                                                            circle
                                                            color="indigo"
                                                        />
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
                                                        <x-ui::avatar
                                                            name="Nuno Maduro"
                                                            size="sm"
                                                            circle
                                                            color="rose"
                                                        />
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
                                                        <x-ui::avatar
                                                            name="Jess Archer"
                                                            size="sm"
                                                            circle
                                                            color="violet"
                                                        />
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
                                            <x-ui::pagination.link href="#guests" :is-active="true">
                                                2</x-ui::pagination.link>
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

                                <x-ui::empty class="border border-zinc-200 dark:border-zinc-800">
                                    <x-ui::empty.header>
                                        <x-ui::empty.media variant="icon" icon="file" />
                                        <x-ui::empty.title>No speakers on the waitlist</x-ui::empty.title>
                                        <x-ui::empty.description>
                                            Invite keynote candidates or open a public CFP to fill this list.
                                        </x-ui::empty.description>
                                    </x-ui::empty.header>
                                    <x-ui::empty.content>
                                        <x-ui::button type="button" variant="outline" size="sm">
                                            Open speaker CFP
                                        </x-ui::button>
                                    </x-ui::empty.content>
                                </x-ui::empty>

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

                        {{-- Insights --}}
                        <x-ui::tabs.content value="insights" class="mt-6!" id="insights">
                            <div class="space-y-6">
                                <div class="space-y-1">
                                    <x-ui::heading :level="2" class="text-xl!">Public page traffic</x-ui::heading>
                                    <x-ui::text size="sm" variant="subtle">
                                        Daily visitors on the Northwind Summit landing page.
                                    </x-ui::text>
                                </div>

                                <x-ui::chart
                                    :value="$insightsData"
                                    label="Daily visitors"
                                    class="aspect-[3/1] w-full max-w-4xl"
                                >
                                    <x-ui::chart.svg>
                                        <x-ui::chart.line field="visitors" class="text-[var(--chart-3)]" />
                                        <x-ui::chart.point field="visitors" class="text-[var(--chart-3)]" />
                                        <x-ui::chart.axis axis="x" field="date">
                                            <x-ui::chart.axis.line />
                                            <x-ui::chart.axis.tick />
                                        </x-ui::chart.axis>
                                        <x-ui::chart.axis axis="y">
                                            <x-ui::chart.axis.grid />
                                            <x-ui::chart.axis.tick />
                                        </x-ui::chart.axis>
                                        <x-ui::chart.cursor />
                                    </x-ui::chart.svg>
                                    <x-ui::chart.tooltip>
                                        <x-ui::chart.tooltip.heading field="date" />
                                        <x-ui::chart.tooltip.value field="visitors" label="Visitors" />
                                    </x-ui::chart.tooltip>
                                </x-ui::chart>
                            </div>
                        </x-ui::tabs.content>

                        {{-- Settings --}}
                        <x-ui::tabs.content value="settings" class="mt-6!" id="settings">
                            <div class="mx-auto max-w-2xl space-y-6">
                                <x-ui::heading :level="2" class="sr-only">Settings</x-ui::heading>

                                <x-ui::card>
                                    <x-ui::card.header>
                                        <x-ui::card.title>Publish checklist</x-ui::card.title>
                                        <x-ui::card.description>
                                            Walk through setup before going live.</x-ui::card.description>
                                    </x-ui::card.header>
                                    <x-ui::card.content>
                                        <x-ui::stepper
                                            default-value="profile"
                                            stepper-id="showcase-publish-stepper"
                                            :linear="true"
                                        >
                                            <x-ui::stepper.list>
                                                <x-ui::stepper.item value="profile" :step="1">
                                                    <x-ui::stepper.trigger>
                                                        <x-ui::stepper.indicator />
                                                        <x-ui::stepper.label>
                                                            <x-ui::stepper.title>Profile</x-ui::stepper.title>
                                                            <x-ui::stepper.description>
                                                                Event details complete</x-ui::stepper.description>
                                                        </x-ui::stepper.label>
                                                    </x-ui::stepper.trigger>
                                                    <x-ui::stepper.separator />
                                                </x-ui::stepper.item>
                                                <x-ui::stepper.item value="tickets" :step="2">
                                                    <x-ui::stepper.trigger>
                                                        <x-ui::stepper.indicator />
                                                        <x-ui::stepper.label>
                                                            <x-ui::stepper.title>Tickets</x-ui::stepper.title>
                                                            <x-ui::stepper.description>
                                                                Pricing and capacity</x-ui::stepper.description>
                                                        </x-ui::stepper.label>
                                                    </x-ui::stepper.trigger>
                                                    <x-ui::stepper.separator />
                                                </x-ui::stepper.item>
                                                <x-ui::stepper.item value="review" :step="3">
                                                    <x-ui::stepper.trigger>
                                                        <x-ui::stepper.indicator />
                                                        <x-ui::stepper.label>
                                                            <x-ui::stepper.title>Review</x-ui::stepper.title>
                                                            <x-ui::stepper.description>
                                                                Final publish check</x-ui::stepper.description>
                                                        </x-ui::stepper.label>
                                                    </x-ui::stepper.trigger>
                                                </x-ui::stepper.item>
                                            </x-ui::stepper.list>

                                            <div class="mt-6 space-y-4">
                                                <x-ui::stepper.content value="profile">
                                                    Confirm the public title, summary, and cover image are ready.
                                                </x-ui::stepper.content>
                                                <x-ui::stepper.content value="tickets">
                                                    Set at least one ticket tier and venue capacity.
                                                </x-ui::stepper.content>
                                                <x-ui::stepper.content value="review">
                                                    Review the public page preview, then publish when ready.
                                                </x-ui::stepper.content>

                                                <x-ui::stepper.navigation>
                                                    <x-ui::stepper.previous />
                                                    <x-ui::stepper.next />
                                                </x-ui::stepper.navigation>
                                            </div>
                                        </x-ui::stepper>
                                    </x-ui::card.content>
                                </x-ui::card>

                                <x-ui::card>
                                    <x-ui::card.header>
                                        <x-ui::card.title>Advanced</x-ui::card.title>
                                        <x-ui::card.description>
                                            Optional tooling most organizers leave closed.</x-ui::card.description>
                                    </x-ui::card.header>
                                    <x-ui::card.content class="space-y-4">
                                        <x-ui::collapsible>
                                            <x-ui::collapsible.trigger>
                                                Webhook &amp; integrations</x-ui::collapsible.trigger>
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
                                                    <x-ui::text class="leading-none font-medium tracking-tight">
                                                        Tip</x-ui::text>
                                                    <x-ui::alert.description>
                                                        We retry failed deliveries for 24 hours with exponential
                                                        backoff.
                                                    </x-ui::alert.description>
                                                </x-ui::alert>
                                            </x-ui::collapsible.content>
                                        </x-ui::collapsible>

                                        <x-ui::separator />

                                        <x-ui::accordion exclusive bordered>
                                            <x-ui::accordion.item value="refunds" :expanded="true">
                                                <x-ui::accordion.trigger>
                                                    What is the refund policy?</x-ui::accordion.trigger>
                                                <x-ui::accordion.content>
                                                    Full refunds until 14 days before the event. After that, tickets
                                                    convert to credit for next year.
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
                                                        Guests are emailed automatically. This cannot be undone from the
                                                        UI.
                                                    </x-ui::dialog.description>
                                                </x-ui::dialog.header>
                                                <x-ui::dialog.footer>
                                                    <x-ui::dialog.cancel>Keep event</x-ui::dialog.cancel>
                                                    <x-ui::dialog.action variant="danger">
                                                        Cancel event</x-ui::dialog.action>
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
            </x-ui::main>
        </x-ui::sidebar.inset>
    </x-ui::sidebar.provider>
@endsection
