<?php

declare(strict_types=1);

namespace Workbench\App\Playbook;

/**
 * Maps interactive components to their stencil:add install command.
 */
final class PlaybookInstallNotes
{
    /**
     * @return array<string, string>
     */
    public static function commands(): array
    {
        return [
            'toggle' => 'stencil:add toggle',
            'toggle-group' => 'stencil:add toggle-group',
            'input-currency' => 'stencil:add input-currency',
            'select' => 'stencil:add select',
            'combobox' => 'stencil:add combobox',
            'file-upload' => 'stencil:add file-upload',
            'repeater' => 'stencil:add repeater',
            'pillbox' => 'stencil:add pillbox',
            'rating' => 'stencil:add rating',
            'color-picker' => 'stencil:add color-picker',
            'date-picker' => 'stencil:add date-picker',
            'time-picker' => 'stencil:add time-picker',
            'datetime-picker' => 'stencil:add datetime-picker',
            'calendar' => 'stencil:add calendar',
            'input-otp' => 'stencil:add input-otp',
            'dialog' => 'stencil:add dialog',
            'command' => 'stencil:add command',
            'accordion' => 'stencil:add accordion',
            'collapsible' => 'stencil:add collapsible',
            'sidebar' => 'stencil:add sidebar',
            'avatar' => 'stencil:add avatar',
            'chart' => 'stencil:add chart',
            'dropdown-menu' => 'stencil:add dropdown-menu',
            'tabs' => 'stencil:add tabs',
            'stepper' => 'stencil:add stepper',
            'tooltip' => 'stencil:add tooltip',
            'icons' => 'stencil:add icon',
        ];
    }

    public static function for(string $slug): ?string
    {
        return self::commands()[$slug] ?? null;
    }
}
