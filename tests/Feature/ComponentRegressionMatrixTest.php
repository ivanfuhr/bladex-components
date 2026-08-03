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
        <x-ui::accordion exclusive transition bordered>
            <x-ui::accordion.item value="one" :expanded="true">
                <x-ui::accordion.trigger>One</x-ui::accordion.trigger>
                <x-ui::accordion.content>First</x-ui::accordion.content>
            </x-ui::accordion.item>
            <x-ui::accordion.item value="two" disabled>
                <x-ui::accordion.trigger>Two</x-ui::accordion.trigger>
                <x-ui::accordion.content>Second</x-ui::accordion.content>
            </x-ui::accordion.item>
        </x-ui::accordion>
    BLADE, ['data-accordion', 'aria-expanded="true"', 'aria-controls=', 'role="region"']],

    'alert' => [<<<'BLADE'
        <x-ui::alert variant="destructive" title="Heads up">
            <x-ui::alert.description>Something failed.</x-ui::alert.description>
        </x-ui::alert>
    BLADE, ['data-alert', 'Heads up', 'Something failed.']],

    'avatar' => [<<<'BLADE'
        <x-ui::avatar name="Ada Lovelace" size="lg" circle color="blue" />
    BLADE, ['data-avatar', 'AL']],

    'badge' => [<<<'BLADE'
        <x-ui::badge variant="secondary" color="green" size="sm" rounded>New</x-ui::badge>
    BLADE, ['data-badge', 'New']],

    'breadcrumb' => [<<<'BLADE'
        <x-ui::breadcrumb>
            <x-ui::breadcrumb.list>
                <x-ui::breadcrumb.item>
                    <x-ui::breadcrumb.link href="/">Home</x-ui::breadcrumb.link>
                </x-ui::breadcrumb.item>
                <x-ui::breadcrumb.separator />
                <x-ui::breadcrumb.item>
                    <x-ui::breadcrumb.page>Current</x-ui::breadcrumb.page>
                </x-ui::breadcrumb.item>
            </x-ui::breadcrumb.list>
        </x-ui::breadcrumb>
    BLADE, ['data-breadcrumb', 'Home', 'Current']],

    'button' => [<<<'BLADE'
        <x-ui::button variant="primary" size="sm" type="submit" disabled data-loading>Save</x-ui::button>
    BLADE, ['data-button', 'type="submit"', 'disabled', 'aria-busy="true"']],

    'button-group' => [<<<'BLADE'
        <x-ui::button-group orientation="horizontal">
            <x-ui::button>A</x-ui::button>
            <x-ui::button-group.separator />
            <x-ui::button>B</x-ui::button>
        </x-ui::button-group>
    BLADE, ['data-button-group', 'A', 'B']],

    'calendar' => [<<<'BLADE'
        <x-ui::calendar mode="single" value="2026-07-29" with-today week-numbers size="default" />
    BLADE, ['data-calendar']],

    'card' => [<<<'BLADE'
        <x-ui::card>
            <x-ui::card.header>
                <x-ui::card.title>Title</x-ui::card.title>
                <x-ui::card.description>Desc</x-ui::card.description>
            </x-ui::card.header>
            <x-ui::card.content>Body</x-ui::card.content>
            <x-ui::card.footer>Foot</x-ui::card.footer>
        </x-ui::card>
    BLADE, ['data-card', 'Title', 'Body']],

    'chart' => [<<<'BLADE'
        <x-ui::chart>
            <x-ui::chart.summary>
                <x-ui::chart.summary.value :value="42" label="Total" />
            </x-ui::chart.summary>
        </x-ui::chart>
    BLADE, ['data-chart', '42']],

    'checkbox' => [<<<'BLADE'
        <x-ui::checkbox name="terms" value="yes" checked invalid size="sm" />
    BLADE, ['data-checkbox', 'name="terms"', 'checked']],

    'collapsible' => [<<<'BLADE'
        <x-ui::collapsible open transition>
            <x-ui::collapsible.trigger>More</x-ui::collapsible.trigger>
            <x-ui::collapsible.content>Details</x-ui::collapsible.content>
        </x-ui::collapsible>
    BLADE, ['data-collapsible', 'aria-expanded="true"', 'aria-controls=', 'role="region"']],

    'color-picker' => [<<<'BLADE'
        <x-ui::color-picker name="accent" value="#112233" size="sm" />
    BLADE, ['data-color-picker', 'name="accent"']],

    'combobox' => [<<<'BLADE'
        <x-ui::combobox name="framework" placeholder="Search">
            <x-ui::combobox.input />
            <x-ui::combobox.content>
                <x-ui::combobox.item value="laravel">Laravel</x-ui::combobox.item>
            </x-ui::combobox.content>
        </x-ui::combobox>
    BLADE, ['data-combobox', 'Laravel']],

    'command' => [<<<'BLADE'
        <x-ui::command>
            <x-ui::command.input placeholder="Type a command" />
            <x-ui::command.list>
                <x-ui::command.item value="calendar">Calendar</x-ui::command.item>
            </x-ui::command.list>
        </x-ui::command>
    BLADE, ['data-command', 'Calendar']],

    'date-picker' => [<<<'BLADE'
        <x-ui::date-picker name="published_at" value="2026-07-29" clearable />
    BLADE, ['data-date-picker', 'name="published_at"', 'data-calendar']],

    'datetime-picker' => [<<<'BLADE'
        <x-ui::datetime-picker name="scheduled_at" value="2026-07-29T14:30:00+00:00" />
    BLADE, ['data-datetime-picker', 'name="scheduled_at"']],

    'dialog' => [<<<'BLADE'
        <x-ui::dialog>
            <x-ui::dialog.trigger>
                <x-ui::button>Open</x-ui::button>
            </x-ui::dialog.trigger>
            <x-ui::dialog.content>
                <x-ui::dialog.header>
                    <x-ui::dialog.title>Title</x-ui::dialog.title>
                </x-ui::dialog.header>
            </x-ui::dialog.content>
        </x-ui::dialog>
    BLADE, ['data-dialog', 'Title']],

    'dropdown-menu' => [<<<'BLADE'
        <x-ui::dropdown-menu>
            <x-ui::dropdown-menu.trigger>
                <x-ui::button>Menu</x-ui::button>
            </x-ui::dropdown-menu.trigger>
            <x-ui::dropdown-menu.content>
                <x-ui::dropdown-menu.item>Item</x-ui::dropdown-menu.item>
            </x-ui::dropdown-menu.content>
        </x-ui::dropdown-menu>
    BLADE, ['data-dropdown-menu', 'Item']],

    'empty' => [<<<'BLADE'
        <x-ui::empty>
            <x-ui::empty.header>
                <x-ui::empty.title>No results</x-ui::empty.title>
                <x-ui::empty.description>Try again.</x-ui::empty.description>
            </x-ui::empty.header>
        </x-ui::empty>
    BLADE, ['data-empty', 'No results']],

    'field' => [<<<'BLADE'
        <x-ui::field name="email">
            <x-ui::field.label>Email</x-ui::field.label>
            <x-ui::input name="email" />
            <x-ui::field.description>We never share it.</x-ui::field.description>
        </x-ui::field>
    BLADE, ['data-field', 'Email']],

    'file-upload' => [<<<'BLADE'
        <x-ui::file-upload name="docs" multiple>
            <x-ui::file-upload.dropzone />
        </x-ui::file-upload>
    BLADE, ['data-file-upload', 'data-file-upload-dropzone']],

    'fonts' => [<<<'BLADE'
        <x-ui::fonts />
    BLADE, ['fonts.googleapis.com', 'preconnect']],

    'heading' => [<<<'BLADE'
        <x-ui::heading level="2" variant="display">Hello</x-ui::heading>
    BLADE, ['Hello']],

    'icon' => [<<<'BLADE'
        <x-ui::icon name="check" class="size-4" />
    BLADE, ['data-icon']],

    'input' => [<<<'BLADE'
        <x-ui::input name="title" value="Draft" size="sm" invalid copyable />
    BLADE, ['data-input', 'name="title"', 'value="Draft"']],

    'input-currency' => [<<<'BLADE'
        <x-ui::input.currency name="price" currency="BRL" locale="pt_BR" :value="1234" />
    BLADE, ['data-input-currency', 'name="price"']],

    'input-otp' => [<<<'BLADE'
        <x-ui::input-otp name="code" length="4" />
    BLADE, ['data-input-otp', 'data-input-otp-slot']],

    'label' => [<<<'BLADE'
        <x-ui::label for="email" required badge="Optional">Email</x-ui::label>
    BLADE, ['Email', 'for="email"']],

    'pagination' => [<<<'BLADE'
        <x-ui::pagination>
            <x-ui::pagination.content>
                <x-ui::pagination.previous href="?page=1" />
                <x-ui::pagination.item>
                    <x-ui::pagination.link href="?page=1" :is-active="true">1</x-ui::pagination.link>
                </x-ui::pagination.item>
                <x-ui::pagination.next href="?page=2" />
            </x-ui::pagination.content>
        </x-ui::pagination>
    BLADE, ['data-pagination', 'aria-current']],

    'pillbox' => [<<<'BLADE'
        <x-ui::pillbox name="tags" :value="['php']" placeholder="Add tag" />
    BLADE, ['data-pillbox', 'name="tags[]"', 'value="php"']],

    'popover' => [<<<'BLADE'
        <x-ui::popover>
            <x-ui::popover.trigger>
                <x-ui::button>Open</x-ui::button>
            </x-ui::popover.trigger>
            <x-ui::popover.content>Popover body</x-ui::popover.content>
        </x-ui::popover>
    BLADE, ['data-popover', 'Popover body']],

    'progress' => [<<<'BLADE'
        <x-ui::progress :value="40" :max="100" size="sm" />
    BLADE, ['data-progress', 'aria-valuenow="40"']],

    'radio' => [<<<'BLADE'
        <x-ui::radio.group name="plan" legend="Plan">
            <x-ui::radio value="pro" checked>Pro</x-ui::radio>
            <x-ui::radio value="free">Free</x-ui::radio>
        </x-ui::radio.group>
    BLADE, ['data-radio', 'name="plan"', 'Pro']],

    'rating' => [<<<'BLADE'
        <x-ui::rating name="score" :value="3" :max="5" />
    BLADE, ['data-rating', 'name="score"']],

    'repeater' => [<<<'BLADE'
        <x-ui::repeater name="guests" :value="[['name' => 'Ada']]" :min="1">
            <x-ui::repeater.item>
                <x-ui::input name="name" />
            </x-ui::repeater.item>
        </x-ui::repeater>
    BLADE, ['data-repeater', 'name="guests']],

    'select' => [<<<'BLADE'
        <x-ui::select name="role" placeholder="Pick">
            <x-ui::select.trigger />
            <x-ui::select.content>
                <x-ui::select.item value="admin">Admin</x-ui::select.item>
            </x-ui::select.content>
        </x-ui::select>
    BLADE, ['data-select', 'Admin']],

    'separator' => [<<<'BLADE'
        <x-ui::separator orientation="horizontal" />
    BLADE, ['data-separator']],

    'sidebar' => [<<<'BLADE'
        <x-ui::sidebar.provider>
            <x-ui::sidebar>
                <x-ui::sidebar.header>Brand</x-ui::sidebar.header>
                <x-ui::sidebar.content>
                    <x-ui::sidebar.menu>
                        <x-ui::sidebar.menu-item>
                            <x-ui::sidebar.menu-button href="/">Home</x-ui::sidebar.menu-button>
                        </x-ui::sidebar.menu-item>
                    </x-ui::sidebar.menu>
                </x-ui::sidebar.content>
            </x-ui::sidebar>
        </x-ui::sidebar.provider>
    BLADE, ['data-sidebar-provider', 'Home']],

    'skeleton' => [<<<'BLADE'
        <x-ui::skeleton class="h-4 w-32" />
    BLADE, ['data-skeleton']],

    'slider' => [<<<'BLADE'
        <x-ui::slider name="volume" :value="25" :min="0" :max="100" />
    BLADE, ['data-slider', 'data-slider-thumb']],

    'stat' => [<<<'BLADE'
        <x-ui::stat label="Revenue" value="$12k" description="MoM" trend="+4%" trend-direction="up" />
    BLADE, ['data-stat', 'Revenue', '$12k']],

    'stepper' => [<<<'BLADE'
        <x-ui::stepper default-value="1">
            <x-ui::stepper.list>
                <x-ui::stepper.item value="1">
                    <x-ui::stepper.trigger>
                        <x-ui::stepper.title>Start</x-ui::stepper.title>
                    </x-ui::stepper.trigger>
                </x-ui::stepper.item>
            </x-ui::stepper.list>
            <x-ui::stepper.content value="1">Step one</x-ui::stepper.content>
        </x-ui::stepper>
    BLADE, ['data-stepper', 'Start']],

    'switch' => [<<<'BLADE'
        <x-ui::switch name="notify" checked />
    BLADE, ['data-switch', 'name="notify"']],

    'table' => [<<<'BLADE'
        <x-ui::table>
            <x-ui::table.header>
                <x-ui::table.row>
                    <x-ui::table.head>Name</x-ui::table.head>
                </x-ui::table.row>
            </x-ui::table.header>
            <x-ui::table.body>
                <x-ui::table.row>
                    <x-ui::table.cell>Ada</x-ui::table.cell>
                </x-ui::table.row>
            </x-ui::table.body>
        </x-ui::table>
    BLADE, ['data-table', 'Ada']],

    'tabs' => [<<<'BLADE'
        <x-ui::tabs default-value="a">
            <x-ui::tabs.list>
                <x-ui::tabs.trigger value="a">A</x-ui::tabs.trigger>
                <x-ui::tabs.trigger value="b">B</x-ui::tabs.trigger>
            </x-ui::tabs.list>
            <x-ui::tabs.content value="a">Panel A</x-ui::tabs.content>
            <x-ui::tabs.content value="b">Panel B</x-ui::tabs.content>
        </x-ui::tabs>
    BLADE, ['data-tabs', 'Panel A']],

    'text' => [<<<'BLADE'
        <x-ui::text size="sm" variant="muted">Muted copy</x-ui::text>
    BLADE, ['Muted copy']],

    'textarea' => [<<<'BLADE'
        <x-ui::textarea name="bio" autosize counter invalid>Hello</x-ui::textarea>
    BLADE, ['data-textarea', 'name="bio"', 'Hello']],

    'time-picker' => [<<<'BLADE'
        <x-ui::time-picker name="starts_at" value="09:30" />
    BLADE, ['data-time-picker', 'name="starts_at"']],

    'toast' => [<<<'BLADE'
        <x-ui::toast.provider>
            <x-ui::toast title="Saved" description="All good." />
        </x-ui::toast.provider>
    BLADE, ['data-toast-provider', 'Saved']],

    'toggle' => [<<<'BLADE'
        <x-ui::toggle :pressed="true" variant="outline" size="sm">Bold</x-ui::toggle>
    BLADE, ['data-toggle', 'aria-pressed="true"']],

    'toggle-group' => [<<<'BLADE'
        <x-ui::toggle-group type="single" default-value="left">
            <x-ui::toggle-group.item value="left">Left</x-ui::toggle-group.item>
            <x-ui::toggle-group.item value="right">Right</x-ui::toggle-group.item>
        </x-ui::toggle-group>
    BLADE, ['data-toggle-group', 'Left']],

    'tooltip' => [<<<'BLADE'
        <x-ui::tooltip>
            <x-ui::tooltip.trigger>
                <x-ui::button>Hint</x-ui::button>
            </x-ui::tooltip.trigger>
            <x-ui::tooltip.content>Helpful tip</x-ui::tooltip.content>
        </x-ui::tooltip>
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
