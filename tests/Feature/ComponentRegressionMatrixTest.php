<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

/**
 * End-to-end smoke matrix: every shipped component family must render without
 * error and expose its primary data-* contract / a11y markers.
 *
 * Deeper prop/variant coverage lives in each *ComponentTest.php file.
 */
dataset('component_regression_matrix', [
    'accordion' => [<<<'BLADE'
        <x-std::accordion exclusive transition bordered>
            <x-std::accordion.item value="one" :expanded="true">
                <x-std::accordion.trigger>One</x-std::accordion.trigger>
                <x-std::accordion.content>First</x-std::accordion.content>
            </x-std::accordion.item>
            <x-std::accordion.item value="two" disabled>
                <x-std::accordion.trigger>Two</x-std::accordion.trigger>
                <x-std::accordion.content>Second</x-std::accordion.content>
            </x-std::accordion.item>
        </x-std::accordion>
    BLADE, ['data-accordion', 'aria-expanded="true"', 'aria-controls=', 'role="region"']],

    'alert' => [<<<'BLADE'
        <x-std::alert variant="destructive" title="Heads up">
            <x-std::alert.description>Something failed.</x-std::alert.description>
        </x-std::alert>
    BLADE, ['data-alert', 'Heads up', 'Something failed.']],

    'avatar' => [<<<'BLADE'
        <x-std::avatar name="Ada Lovelace" size="lg" circle color="blue" />
    BLADE, ['data-avatar', 'AL']],

    'badge' => [<<<'BLADE'
        <x-std::badge variant="secondary" color="green" size="sm" rounded>New</x-std::badge>
    BLADE, ['data-badge', 'New']],

    'breadcrumb' => [<<<'BLADE'
        <x-std::breadcrumb>
            <x-std::breadcrumb.list>
                <x-std::breadcrumb.item>
                    <x-std::breadcrumb.link href="/">Home</x-std::breadcrumb.link>
                </x-std::breadcrumb.item>
                <x-std::breadcrumb.separator />
                <x-std::breadcrumb.item>
                    <x-std::breadcrumb.page>Current</x-std::breadcrumb.page>
                </x-std::breadcrumb.item>
            </x-std::breadcrumb.list>
        </x-std::breadcrumb>
    BLADE, ['data-breadcrumb', 'Home', 'Current']],

    'button' => [<<<'BLADE'
        <x-std::button variant="primary" size="sm" type="submit" disabled data-loading>Save</x-std::button>
    BLADE, ['data-button', 'type="submit"', 'disabled', 'aria-busy="true"']],

    'button-group' => [<<<'BLADE'
        <x-std::button-group orientation="horizontal">
            <x-std::button>A</x-std::button>
            <x-std::button-group.separator />
            <x-std::button>B</x-std::button>
        </x-std::button-group>
    BLADE, ['data-button-group', 'A', 'B']],

    'calendar' => [<<<'BLADE'
        <x-std::calendar mode="single" value="2026-07-29" with-today week-numbers size="default" />
    BLADE, ['data-calendar']],

    'card' => [<<<'BLADE'
        <x-std::card>
            <x-std::card.header>
                <x-std::card.title>Title</x-std::card.title>
                <x-std::card.description>Desc</x-std::card.description>
            </x-std::card.header>
            <x-std::card.content>Body</x-std::card.content>
            <x-std::card.footer>Foot</x-std::card.footer>
        </x-std::card>
    BLADE, ['data-card', 'Title', 'Body']],

    'chart' => [<<<'BLADE'
        <x-std::chart>
            <x-std::chart.summary>
                <x-std::chart.summary.value :value="42" label="Total" />
            </x-std::chart.summary>
        </x-std::chart>
    BLADE, ['data-chart', '42']],

    'checkbox' => [<<<'BLADE'
        <x-std::checkbox name="terms" value="yes" checked invalid size="sm" />
    BLADE, ['data-checkbox', 'name="terms"', 'checked']],

    'collapsible' => [<<<'BLADE'
        <x-std::collapsible open transition>
            <x-std::collapsible.trigger>More</x-std::collapsible.trigger>
            <x-std::collapsible.content>Details</x-std::collapsible.content>
        </x-std::collapsible>
    BLADE, ['data-collapsible', 'aria-expanded="true"', 'aria-controls=', 'role="region"']],

    'scroll-area' => [<<<'BLADE'
        <x-std::scroll-area class="h-40" aria-label="List">
            <div>One</div>
            <div>Two</div>
        </x-std::scroll-area>
    BLADE, ['data-scroll-area', 'data-scroll-area-viewport', 'data-scroll-area-scrollbar', 'tabindex="0"']],

    'color-picker' => [<<<'BLADE'
        <x-std::color-picker name="accent" value="#112233" size="sm" />
    BLADE, ['data-color-picker', 'name="accent"']],

    'combobox' => [<<<'BLADE'
        <x-std::combobox name="framework" placeholder="Search">
            <x-std::combobox.input />
            <x-std::combobox.content>
                <x-std::combobox.item value="laravel">Laravel</x-std::combobox.item>
            </x-std::combobox.content>
        </x-std::combobox>
    BLADE, ['data-combobox', 'Laravel']],

    'command' => [<<<'BLADE'
        <x-std::command>
            <x-std::command.input placeholder="Type a command" />
            <x-std::command.list>
                <x-std::command.item value="calendar">Calendar</x-std::command.item>
            </x-std::command.list>
        </x-std::command>
    BLADE, ['data-command', 'Calendar']],

    'date-picker' => [<<<'BLADE'
        <x-std::date-picker name="published_at" value="2026-07-29" clearable />
    BLADE, ['data-date-picker', 'name="published_at"', 'data-calendar']],

    'datetime-picker' => [<<<'BLADE'
        <x-std::datetime-picker name="scheduled_at" value="2026-07-29T14:30:00+00:00" />
    BLADE, ['data-datetime-picker', 'name="scheduled_at"']],

    'dialog' => [<<<'BLADE'
        <x-std::dialog>
            <x-std::dialog.trigger>
                <x-std::button>Open</x-std::button>
            </x-std::dialog.trigger>
            <x-std::dialog.content>
                <x-std::dialog.header>
                    <x-std::dialog.title>Title</x-std::dialog.title>
                </x-std::dialog.header>
            </x-std::dialog.content>
        </x-std::dialog>
    BLADE, ['data-dialog', 'Title']],

    'dropdown-menu' => [<<<'BLADE'
        <x-std::dropdown-menu>
            <x-std::dropdown-menu.trigger>
                <x-std::button>Menu</x-std::button>
            </x-std::dropdown-menu.trigger>
            <x-std::dropdown-menu.content>
                <x-std::dropdown-menu.item>Item</x-std::dropdown-menu.item>
            </x-std::dropdown-menu.content>
        </x-std::dropdown-menu>
    BLADE, ['data-dropdown-menu', 'Item']],

    'empty' => [<<<'BLADE'
        <x-std::empty>
            <x-std::empty.header>
                <x-std::empty.title>No results</x-std::empty.title>
                <x-std::empty.description>Try again.</x-std::empty.description>
            </x-std::empty.header>
        </x-std::empty>
    BLADE, ['data-empty', 'No results']],

    'field' => [<<<'BLADE'
        <x-std::field name="email">
            <x-std::field.label>Email</x-std::field.label>
            <x-std::input name="email" />
            <x-std::field.description>We never share it.</x-std::field.description>
        </x-std::field>
    BLADE, ['data-field', 'Email']],

    'file-upload' => [<<<'BLADE'
        <x-std::file-upload name="docs" multiple>
            <x-std::file-upload.dropzone />
        </x-std::file-upload>
    BLADE, ['data-file-upload', 'data-file-upload-dropzone']],

    'fonts' => [<<<'BLADE'
        <x-std::fonts />
    BLADE, ['fonts.googleapis.com', 'preconnect']],

    'grid' => [<<<'BLADE'
        <x-std::grid md="3">
            <x-std::grid.item span="full">Full</x-std::grid.item>
        </x-std::grid>
    BLADE, ['data-grid', 'data-grid-item', '@md:grid-cols-3', 'col-span-full']],

    'heading' => [<<<'BLADE'
        <x-std::heading level="2" variant="display">Hello</x-std::heading>
    BLADE, ['Hello']],

    'icon' => [<<<'BLADE'
        <x-std::icon name="check" class="size-4" />
    BLADE, ['data-icon']],

    'input' => [<<<'BLADE'
        <x-std::input name="title" value="Draft" size="sm" invalid copyable />
    BLADE, ['data-input', 'name="title"', 'value="Draft"']],

    'input-currency' => [<<<'BLADE'
        <x-std::input.currency name="price" currency="BRL" locale="pt_BR" :value="1234" />
    BLADE, ['data-input-currency', 'name="price"']],

    'input-otp' => [<<<'BLADE'
        <x-std::input-otp name="code" length="4" />
    BLADE, ['data-input-otp', 'data-input-otp-slot']],

    'label' => [<<<'BLADE'
        <x-std::label for="email" required badge="Optional">Email</x-std::label>
    BLADE, ['Email', 'for="email"']],

    'pagination' => [<<<'BLADE'
        <x-std::pagination>
            <x-std::pagination.content>
                <x-std::pagination.previous href="?page=1" />
                <x-std::pagination.item>
                    <x-std::pagination.link href="?page=1" :is-active="true">1</x-std::pagination.link>
                </x-std::pagination.item>
                <x-std::pagination.next href="?page=2" />
            </x-std::pagination.content>
        </x-std::pagination>
    BLADE, ['data-pagination', 'aria-current']],

    'pillbox' => [<<<'BLADE'
        <x-std::pillbox name="tags" :value="['php']" placeholder="Add tag" />
    BLADE, ['data-pillbox', 'name="tags[]"', 'value="php"']],

    'popover' => [<<<'BLADE'
        <x-std::popover>
            <x-std::popover.trigger>
                <x-std::button>Open</x-std::button>
            </x-std::popover.trigger>
            <x-std::popover.content>Popover body</x-std::popover.content>
        </x-std::popover>
    BLADE, ['data-popover', 'Popover body']],

    'progress' => [<<<'BLADE'
        <x-std::progress :value="40" :max="100" size="sm" />
    BLADE, ['data-progress', 'aria-valuenow="40"']],

    'radio' => [<<<'BLADE'
        <x-std::radio.group name="plan" legend="Plan">
            <x-std::radio value="pro" checked>Pro</x-std::radio>
            <x-std::radio value="free">Free</x-std::radio>
        </x-std::radio.group>
    BLADE, ['data-radio', 'name="plan"', 'Pro']],

    'rating' => [<<<'BLADE'
        <x-std::rating name="score" :value="3" :max="5" />
    BLADE, ['data-rating', 'name="score"']],

    'repeater' => [<<<'BLADE'
        <x-std::repeater name="guests" :value="[['name' => 'Ada']]" :min="1">
            <x-std::repeater.item>
                <x-std::input name="name" />
            </x-std::repeater.item>
        </x-std::repeater>
    BLADE, ['data-repeater', 'name="guests']],

    'select' => [<<<'BLADE'
        <x-std::select name="role" placeholder="Pick">
            <x-std::select.trigger />
            <x-std::select.content>
                <x-std::select.item value="admin">Admin</x-std::select.item>
            </x-std::select.content>
        </x-std::select>
    BLADE, ['data-select', 'Admin']],

    'separator' => [<<<'BLADE'
        <x-std::separator orientation="horizontal" />
    BLADE, ['data-separator']],

    'sidebar' => [<<<'BLADE'
        <x-std::sidebar.provider>
            <x-std::sidebar>
                <x-std::sidebar.header>Brand</x-std::sidebar.header>
                <x-std::sidebar.content>
                    <x-std::sidebar.menu>
                        <x-std::sidebar.menu-item>
                            <x-std::sidebar.menu-button href="/">Home</x-std::sidebar.menu-button>
                        </x-std::sidebar.menu-item>
                    </x-std::sidebar.menu>
                </x-std::sidebar.content>
            </x-std::sidebar>
        </x-std::sidebar.provider>
    BLADE, ['data-sidebar-provider', 'Home']],

    'skeleton' => [<<<'BLADE'
        <x-std::skeleton class="h-4 w-32" />
    BLADE, ['data-skeleton']],

    'slider' => [<<<'BLADE'
        <x-std::slider name="volume" :value="25" :min="0" :max="100" />
    BLADE, ['data-slider', 'data-slider-thumb']],

    'stat' => [<<<'BLADE'
        <x-std::stat label="Revenue" value="$12k" description="MoM" trend="+4%" trend-direction="up" />
    BLADE, ['data-stat', 'Revenue', '$12k']],

    'stepper' => [<<<'BLADE'
        <x-std::stepper default-value="1">
            <x-std::stepper.list>
                <x-std::stepper.item value="1">
                    <x-std::stepper.trigger>
                        <x-std::stepper.title>Start</x-std::stepper.title>
                    </x-std::stepper.trigger>
                </x-std::stepper.item>
            </x-std::stepper.list>
            <x-std::stepper.content value="1">Step one</x-std::stepper.content>
        </x-std::stepper>
    BLADE, ['data-stepper', 'Start']],

    'switch' => [<<<'BLADE'
        <x-std::switch name="notify" checked />
    BLADE, ['data-switch', 'name="notify"']],

    'table' => [<<<'BLADE'
        <x-std::table>
            <x-std::table.header>
                <x-std::table.row>
                    <x-std::table.head>Name</x-std::table.head>
                </x-std::table.row>
            </x-std::table.header>
            <x-std::table.body>
                <x-std::table.row>
                    <x-std::table.cell>Ada</x-std::table.cell>
                </x-std::table.row>
            </x-std::table.body>
        </x-std::table>
    BLADE, ['data-table', 'Ada']],

    'tabs' => [<<<'BLADE'
        <x-std::tabs default-value="a">
            <x-std::tabs.list>
                <x-std::tabs.trigger value="a">A</x-std::tabs.trigger>
                <x-std::tabs.trigger value="b">B</x-std::tabs.trigger>
            </x-std::tabs.list>
            <x-std::tabs.content value="a">Panel A</x-std::tabs.content>
            <x-std::tabs.content value="b">Panel B</x-std::tabs.content>
        </x-std::tabs>
    BLADE, ['data-tabs', 'Panel A']],

    'text' => [<<<'BLADE'
        <x-std::text size="sm" variant="muted">Muted copy</x-std::text>
    BLADE, ['Muted copy']],

    'textarea' => [<<<'BLADE'
        <x-std::textarea name="bio" autosize counter invalid>Hello</x-std::textarea>
    BLADE, ['data-textarea', 'name="bio"', 'Hello']],

    'time-picker' => [<<<'BLADE'
        <x-std::time-picker name="starts_at" value="09:30" />
    BLADE, ['data-time-picker', 'name="starts_at"']],

    'toast' => [<<<'BLADE'
        <x-std::toast.provider>
            <x-std::toast title="Saved" description="All good." />
        </x-std::toast.provider>
    BLADE, ['data-toast-provider', 'Saved']],

    'toggle' => [<<<'BLADE'
        <x-std::toggle :pressed="true" variant="outline" size="sm">Bold</x-std::toggle>
    BLADE, ['data-toggle', 'aria-pressed="true"']],

    'toggle-group' => [<<<'BLADE'
        <x-std::toggle-group type="single" default-value="left">
            <x-std::toggle-group.item value="left">Left</x-std::toggle-group.item>
            <x-std::toggle-group.item value="right">Right</x-std::toggle-group.item>
        </x-std::toggle-group>
    BLADE, ['data-toggle-group', 'Left']],

    'tooltip' => [<<<'BLADE'
        <x-std::tooltip>
            <x-std::tooltip.trigger>
                <x-std::button>Hint</x-std::button>
            </x-std::tooltip.trigger>
            <x-std::tooltip.content>Helpful tip</x-std::tooltip.content>
        </x-std::tooltip>
    BLADE, ['data-tooltip', 'Helpful tip']],
]);

it('renders every component family without error', function (string $blade, array $markers) {
    if (str_contains($blade, 'input.currency') && ! extension_loaded('intl')) {
        $this->markTestSkipped('The intl extension is required for Number::currency.');
    }

    $html = Blade::render($blade);

    expect($html)->not->toBeEmpty();

    foreach ($markers as $marker) {
        expect($html)->toContain($marker);
    }
})->with('component_regression_matrix');
