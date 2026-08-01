<?php

declare(strict_types=1);

namespace Workbench\App\Playbook;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PlaybookRegistry
{
    /**
     * Catalog sections for the playbook index (Operate IA).
     *
     * @var array<string, array{label: string, slugs: list<string>}>
     */
    private const CATEGORIES = [
        'forms' => [
            'label' => 'Forms',
            'slugs' => [
                'button',
                'button-group',
                'toggle',
                'toggle-group',
                'input',
                'input-currency',
                'select',
                'combobox',
                'file-upload',
                'repeater',
                'pillbox',
                'rating',
                'color-picker',
                'input-otp',
                'slider',
                'label',
                'field',
                'textarea',
                'checkbox',
                'radio',
                'switch',
            ],
        ],
        'typography' => [
            'label' => 'Typography',
            'slugs' => [
                'text',
                'heading',
            ],
        ],
        'overlays' => [
            'label' => 'Overlays',
            'slugs' => [
                'dialog',
                'command',
                'dropdown-menu',
                'popover',
                'tooltip',
            ],
        ],
        'feedback' => [
            'label' => 'Feedback',
            'slugs' => [
                'toast',
                'alert',
                'progress',
                'skeleton',
                'empty',
                'badge',
            ],
        ],
        'navigation' => [
            'label' => 'Navigation',
            'slugs' => [
                'breadcrumb',
                'tabs',
                'stepper',
                'pagination',
                'accordion',
                'collapsible',
                'sidebar',
            ],
        ],
        'display' => [
            'label' => 'Display',
            'slugs' => [
                'avatar',
                'card',
                'stat',
                'table',
                'separator',
                'icons',
            ],
        ],
        'datetime' => [
            'label' => 'Date & time',
            'slugs' => [
                'calendar',
                'date-picker',
                'time-picker',
                'datetime-picker',
            ],
        ],
    ];

    /** @var Collection<string, ComponentPlaybook>|null */
    private ?Collection $playbooks = null;

    /**
     * @return list<ComponentPlaybook>
     */
    public function all(): array
    {
        return $this->playbooks()->values()->all();
    }

    /**
     * @return list<array{key: string, label: string, playbooks: list<ComponentPlaybook>}>
     */
    public function grouped(): array
    {
        $bySlug = $this->playbooks();
        $groups = [];

        foreach (self::CATEGORIES as $key => $meta) {
            $playbooks = [];

            foreach ($meta['slugs'] as $slug) {
                $playbook = $bySlug->get($slug);

                if ($playbook instanceof ComponentPlaybook) {
                    $playbooks[] = $playbook;
                }
            }

            if ($playbooks === []) {
                continue;
            }

            $groups[] = [
                'key' => $key,
                'label' => $meta['label'],
                'playbooks' => $playbooks,
            ];
        }

        return $groups;
    }

    public function get(string $slug): ComponentPlaybook
    {
        $playbook = $this->playbooks()->get($slug);

        if (! $playbook instanceof ComponentPlaybook) {
            throw new NotFoundHttpException("Playbook component [{$slug}] was not found.");
        }

        return $playbook;
    }

    public function has(string $slug): bool
    {
        return $this->playbooks()->has($slug);
    }

    /**
     * Resolve the README media slug for a playground component, if a media view exists.
     */
    public function mediaSlug(string $slug): ?string
    {
        $resolved = match ($slug) {
            'text', 'heading' => 'typography',
            'icon' => 'icons',
            default => $slug,
        };

        $path = dirname(__DIR__, 2).'/resources/views/playbook/media/'.$resolved.'.blade.php';

        if (! is_file($path)) {
            return null;
        }

        return $resolved;
    }

    /**
     * Previous / next siblings within the same catalog category.
     *
     * @return array{previous: ?ComponentPlaybook, next: ?ComponentPlaybook}
     */
    public function siblings(string $slug): array
    {
        foreach ($this->grouped() as $group) {
            /** @var list<ComponentPlaybook> $playbooks */
            $playbooks = $group['playbooks'];

            foreach ($playbooks as $index => $playbook) {
                if ($playbook->slug !== $slug) {
                    continue;
                }

                return [
                    'previous' => $playbooks[$index - 1] ?? null,
                    'next' => $playbooks[$index + 1] ?? null,
                ];
            }
        }

        return [
            'previous' => null,
            'next' => null,
        ];
    }

    /**
     * @return Collection<string, ComponentPlaybook>
     */
    private function playbooks(): Collection
    {
        if ($this->playbooks !== null) {
            return $this->playbooks;
        }

        $definitions = [
            $this->button(),
            $this->buttonGroup(),
            $this->toggle(),
            $this->toggleGroup(),
            $this->input(),
            $this->inputCurrency(),
            $this->select(),
            $this->combobox(),
            $this->fileUpload(),
            $this->repeater(),
            $this->pillbox(),
            $this->rating(),
            $this->colorPicker(),
            $this->inputOtp(),
            $this->slider(),
            $this->label(),
            $this->field(),
            $this->textarea(),
            $this->checkbox(),
            $this->radio(),
            $this->switch(),
            $this->text(),
            $this->heading(),
            $this->dialog(),
            $this->command(),
            $this->accordion(),
            $this->collapsible(),
            $this->sidebar(),
            $this->avatar(),
            $this->badge(),
            $this->breadcrumb(),
            $this->card(),
            $this->stat(),
            $this->dropdownMenu(),
            $this->popover(),
            $this->separator(),
            $this->skeleton(),
            $this->empty(),
            $this->tabs(),
            $this->stepper(),
            $this->tooltip(),
            $this->toast(),
            $this->progress(),
            $this->alert(),
            $this->table(),
            $this->icons(),
            $this->pagination(),
            $this->calendar(),
            $this->datePicker(),
            $this->timePicker(),
            $this->datetimePicker(),
        ];

        $this->playbooks = collect($definitions)->keyBy(static fn (ComponentPlaybook $playbook): string => $playbook->slug);

        return $this->playbooks;
    }

    private function button(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('variant', 'Variant', 'select', [
                'outline' => 'Outline',
                'primary' => 'Primary',
                'secondary' => 'Secondary',
                'danger' => 'Danger',
                'ghost' => 'Ghost',
                'subtle' => 'Subtle',
                'link' => 'Link',
            ], 'outline'),
            new PlaybookControl('size', 'Size', 'select', [
                'xs' => 'Extra small',
                'sm' => 'Small',
                'default' => 'Default',
                'lg' => 'Large',
            ], 'default'),
            new PlaybookControl('type', 'Type', 'select', [
                'button' => 'Button',
                'submit' => 'Submit',
                'reset' => 'Reset',
            ], 'button'),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
            new PlaybookControl('square', 'Square (icon)', 'checkbox', [], false),
            new PlaybookControl('as_link', 'Render as link', 'checkbox', [], false),
            new PlaybookControl('show_affixes', 'Leading / trailing slots', 'checkbox', [], false),
        ];

        return new ComponentPlaybook(
            slug: 'button',
            title: 'Button',
            description: 'Composable button primitive with variants, sizes, link mode, and grouped layouts.',
            controls: $controls,
            defaultState: [
                'variant' => 'outline',
                'size' => 'default',
                'type' => 'button',
                'disabled' => false,
                'square' => false,
                'as_link' => false,
                'show_affixes' => false,
            ],
            previewView: 'workbench::playbook.previews.button',
        );
    }

    private function buttonGroup(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'button-group',
            title: 'Button Group',
            description: 'Attach related action buttons with shared borders. Use toggle-group for pressed state.',
            controls: [
                new PlaybookControl('orientation', 'Orientation', 'select', [
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                ], 'horizontal'),
                new PlaybookControl('show_separator', 'Separator', 'checkbox', [], false),
                new PlaybookControl('show_text', 'Text affix', 'checkbox', [], false),
            ],
            defaultState: [
                'orientation' => 'horizontal',
                'show_separator' => false,
                'show_text' => false,
            ],
            previewView: 'workbench::playbook.previews.button-group',
        );
    }

    private function toggle(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'toggle',
            title: 'Toggle',
            description: 'Pressed/unpressed button control with aria-pressed. Requires toggle.js.',
            controls: [
                new PlaybookControl('variant', 'Variant', 'select', [
                    'default' => 'Default',
                    'outline' => 'Outline',
                ], 'default'),
                new PlaybookControl('size', 'Size', 'select', [
                    'sm' => 'Small',
                    'default' => 'Default',
                    'lg' => 'Large',
                ], 'default'),
                new PlaybookControl('pressed', 'Pressed', 'checkbox', [], false),
                new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
            ],
            defaultState: [
                'variant' => 'default',
                'size' => 'default',
                'pressed' => false,
                'disabled' => false,
            ],
            previewView: 'workbench::playbook.previews.toggle',
        );
    }

    private function toggleGroup(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'toggle-group',
            title: 'Toggle Group',
            description: 'Single or multiple toggle selection with radiogroup/group semantics. Requires toggle-group.js.',
            controls: [
                new PlaybookControl('type', 'Type', 'select', [
                    'single' => 'Single',
                    'multiple' => 'Multiple',
                ], 'single'),
                new PlaybookControl('variant', 'Variant', 'select', [
                    'default' => 'Default',
                    'outline' => 'Outline',
                ], 'outline'),
                new PlaybookControl('size', 'Size', 'select', [
                    'sm' => 'Small',
                    'default' => 'Default',
                    'lg' => 'Large',
                ], 'default'),
                new PlaybookControl('orientation', 'Orientation', 'select', [
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                ], 'horizontal'),
                new PlaybookControl('spacing', 'Spacing', 'select', [
                    '0' => 'Connected (0)',
                    '2' => 'Gapped (2)',
                ], '0'),
            ],
            defaultState: [
                'type' => 'single',
                'variant' => 'outline',
                'size' => 'default',
                'orientation' => 'horizontal',
                'spacing' => '0',
            ],
            previewView: 'workbench::playbook.previews.toggle-group',
        );
    }

    private function input(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
            new PlaybookControl('readonly', 'Readonly', 'checkbox', [], false),
            new PlaybookControl('show_affixes', 'Leading / trailing affixes', 'checkbox', [], true),
            new PlaybookControl('show_prefix_suffix', 'Prefix / suffix text', 'checkbox', [], false),
        ];

        return new ComponentPlaybook(
            slug: 'input',
            title: 'Input',
            description: 'Accessible text input primitive with optional affixes and group layout.',
            controls: $controls,
            defaultState: [
                'invalid' => false,
                'disabled' => false,
                'readonly' => false,
                'show_affixes' => true,
                'show_prefix_suffix' => false,
            ],
            previewView: 'workbench::playbook.previews.input',
        );
    }

    private function inputCurrency(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
            new PlaybookControl('readonly', 'Readonly', 'checkbox', [], false),
            new PlaybookControl('currency', 'Currency', 'select', [
                'BRL' => 'BRL',
                'USD' => 'USD',
                'EUR' => 'EUR',
            ], 'BRL'),
            new PlaybookControl('locale', 'Locale', 'select', [
                'pt_BR' => 'pt_BR',
                'en' => 'en',
                'en_US' => 'en_US',
            ], 'pt_BR'),
        ];

        return new ComponentPlaybook(
            slug: 'input-currency',
            title: 'Input Currency',
            description: 'Currency field with formatted display and a hidden float for form posts. Requires input-currency.js.',
            controls: $controls,
            defaultState: [
                'invalid' => false,
                'disabled' => false,
                'readonly' => false,
                'currency' => 'BRL',
                'locale' => 'pt_BR',
            ],
            previewView: 'workbench::playbook.previews.input-currency',
        );
    }

    private function select(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
            new PlaybookControl('multiple', 'Multiple', 'checkbox', [], false),
            new PlaybookControl('size', 'Size', 'select', [
                'default' => 'Default',
                'sm' => 'Small',
            ], 'default'),
            new PlaybookControl('display', 'Display', 'select', [
                'count' => 'Count',
                'chips' => 'Chips',
            ], 'count'),
            new PlaybookControl('placeholder', 'Placeholder', 'select', [
                'Choose industry…' => 'Choose industry…',
                'Select a role…' => 'Select a role…',
            ], 'Choose industry…'),
        ];

        return new ComponentPlaybook(
            slug: 'select',
            title: 'Select',
            description: 'Custom listbox select with compound sub-components. Requires the package select.js script.',
            controls: $controls,
            defaultState: [
                'invalid' => false,
                'disabled' => false,
                'multiple' => false,
                'size' => 'default',
                'display' => 'count',
                'placeholder' => 'Choose industry…',
            ],
            previewView: 'workbench::playbook.previews.select',
        );
    }

    private function combobox(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
            new PlaybookControl('size', 'Size', 'select', [
                'default' => 'Default',
                'sm' => 'Small',
            ], 'default'),
            new PlaybookControl('placeholder', 'Placeholder', 'select', [
                'Search frameworks…' => 'Search frameworks…',
                'Find a language…' => 'Find a language…',
            ], 'Search frameworks…'),
        ];

        return new ComponentPlaybook(
            slug: 'combobox',
            title: 'Combobox',
            description: 'Filterable combobox / autocomplete with typeahead list. Requires the package combobox.js script.',
            controls: $controls,
            defaultState: [
                'invalid' => false,
                'disabled' => false,
                'size' => 'default',
                'placeholder' => 'Search frameworks…',
            ],
            previewView: 'workbench::playbook.previews.combobox',
        );
    }

    private function fileUpload(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
            new PlaybookControl('multiple', 'Multiple', 'checkbox', [], false),
            new PlaybookControl('size', 'Size', 'select', [
                'default' => 'Default',
                'sm' => 'Small',
            ], 'default'),
            new PlaybookControl('accept', 'Accept', 'select', [
                '' => 'Any',
                'image/*' => 'Images',
                '.pdf' => 'PDF',
            ], ''),
        ];

        return new ComponentPlaybook(
            slug: 'file-upload',
            title: 'File Upload',
            description: 'Native file input with drag-and-drop dropzone and removable file list. Requires the package file-upload.js script.',
            controls: $controls,
            defaultState: [
                'invalid' => false,
                'disabled' => false,
                'multiple' => false,
                'size' => 'default',
                'accept' => '',
            ],
            previewView: 'workbench::playbook.previews.file-upload',
        );
    }

    private function repeater(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
            new PlaybookControl('min', 'Min rows', 'select', [
                '0' => '0',
                '1' => '1',
                '2' => '2',
            ], '1'),
            new PlaybookControl('max', 'Max rows', 'select', [
                '' => 'None',
                '3' => '3',
                '5' => '5',
                '10' => '10',
            ], ''),
        ];

        return new ComponentPlaybook(
            slug: 'repeater',
            title: 'Repeater',
            description: 'Composition-first repeater for dynamic Laravel array fields. Requires the package repeater.js script.',
            controls: $controls,
            defaultState: [
                'invalid' => false,
                'disabled' => false,
                'min' => '1',
                'max' => '',
            ],
            previewView: 'workbench::playbook.previews.repeater',
            wide: true,
        );
    }

    private function pillbox(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
            new PlaybookControl('max', 'Max tags', 'select', [
                '' => 'None',
                '3' => '3',
                '5' => '5',
            ], ''),
        ];

        return new ComponentPlaybook(
            slug: 'pillbox',
            title: 'Pillbox',
            description: 'Free-text tags input. Requires pillbox.js.',
            controls: $controls,
            defaultState: [
                'invalid' => false,
                'disabled' => false,
                'max' => '',
            ],
            previewView: 'workbench::playbook.previews.pillbox',
        );
    }

    private function rating(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'rating',
            title: 'Rating',
            description: 'Star rating input. Requires rating.js.',
            controls: [
                new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
                new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
                new PlaybookControl('max', 'Max stars', 'select', [
                    '3' => '3',
                    '5' => '5',
                    '10' => '10',
                ], '5'),
            ],
            defaultState: [
                'invalid' => false,
                'disabled' => false,
                'max' => '5',
            ],
            previewView: 'workbench::playbook.previews.rating',
        );
    }

    private function colorPicker(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'color-picker',
            title: 'Color Picker',
            description: 'Popover color picker with SV canvas, hue slider, and swatches. Requires color-picker.js.',
            controls: [
                new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
                new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
            ],
            defaultState: [
                'invalid' => false,
                'disabled' => false,
            ],
            previewView: 'workbench::playbook.previews.color-picker',
        );
    }

    private function inputOtp(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
            new PlaybookControl('size', 'Size', 'select', [
                'default' => 'Default',
                'sm' => 'Small',
            ], 'default'),
            new PlaybookControl('length', 'Length', 'select', [
                '4' => '4',
                '6' => '6',
                '8' => '8',
            ], '6'),
            new PlaybookControl('mode', 'Mode', 'select', [
                'numeric' => 'Numeric',
                'alphanumeric' => 'Alphanumeric',
            ], 'numeric'),
            new PlaybookControl('separated', 'Separated', 'checkbox', [], true),
        ];

        return new ComponentPlaybook(
            slug: 'input-otp',
            title: 'Input OTP',
            description: 'One-time password / PIN slots with paste and keyboard navigation. Requires the package input-otp.js script.',
            controls: $controls,
            defaultState: [
                'invalid' => false,
                'disabled' => false,
                'size' => 'default',
                'length' => '6',
                'mode' => 'numeric',
                'separated' => true,
            ],
            previewView: 'workbench::playbook.previews.input-otp',
        );
    }

    private function slider(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
            new PlaybookControl('range', 'Range', 'checkbox', [], false),
            new PlaybookControl('size', 'Size', 'select', [
                'default' => 'Default',
                'sm' => 'Small',
            ], 'default'),
            new PlaybookControl('step', 'Step', 'select', [
                '1' => '1',
                '5' => '5',
                '10' => '10',
            ], '1'),
        ];

        return new ComponentPlaybook(
            slug: 'slider',
            title: 'Slider',
            description: 'Accessible single or dual-thumb range slider. Requires the package slider.js script.',
            controls: $controls,
            defaultState: [
                'invalid' => false,
                'disabled' => false,
                'range' => false,
                'size' => 'default',
                'step' => '1',
            ],
            previewView: 'workbench::playbook.previews.slider',
        );
    }

    private function text(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('size', 'Size', 'select', [
                'sm' => 'Small',
                'default' => 'Default',
                'lg' => 'Large',
                'xl' => 'Extra large',
            ], 'default'),
            new PlaybookControl('variant', 'Variant', 'select', [
                'default' => 'Default',
                'strong' => 'Strong',
                'subtle' => 'Subtle',
                'error' => 'Error',
            ], 'default'),
            new PlaybookControl('color', 'Color', 'select', [
                'default' => 'Default',
                'blue' => 'Blue',
                'emerald' => 'Emerald',
                'red' => 'Red',
            ], 'default'),
            new PlaybookControl('inline', 'Inline (span)', 'checkbox', [], false),
        ];

        return new ComponentPlaybook(
            slug: 'text',
            title: 'Text',
            description: 'Body copy primitive with standardized size scale and automatic body font role.',
            controls: $controls,
            defaultState: [
                'size' => 'default',
                'variant' => 'default',
                'color' => 'default',
                'inline' => false,
            ],
            previewView: 'workbench::playbook.previews.text',
        );
    }

    private function heading(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('level', 'Level', 'select', [
                '1' => 'H1',
                '2' => 'H2',
                '3' => 'H3',
                '4' => 'H4',
                '5' => 'H5',
                '6' => 'H6',
            ], '2'),
            new PlaybookControl('variant', 'Variant', 'select', [
                'default' => 'Default',
                'subtle' => 'Subtle',
            ], 'default'),
        ];

        return new ComponentPlaybook(
            slug: 'heading',
            title: 'Heading',
            description: 'Semantic heading primitive with level-driven size scale and automatic heading font role.',
            controls: $controls,
            defaultState: [
                'level' => '2',
                'variant' => 'default',
            ],
            previewView: 'workbench::playbook.previews.heading',
        );
    }

    private function label(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('badge', 'Badge', 'select', [
                '' => 'None',
                'Required' => 'Required',
                'Optional' => 'Optional',
            ], ''),
            new PlaybookControl('required', 'Required indicator', 'checkbox', [], false),
        ];

        return new ComponentPlaybook(
            slug: 'label',
            title: 'Label',
            description: 'Accessible label primitive with optional badge and required marker.',
            controls: $controls,
            defaultState: [
                'badge' => '',
                'required' => false,
            ],
            previewView: 'workbench::playbook.previews.label',
        );
    }

    private function field(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('orientation', 'Orientation', 'select', [
                'block' => 'Block',
                'inline' => 'Inline',
            ], 'block'),
            new PlaybookControl('size', 'Input size', 'select', [
                'default' => 'Default',
                'sm' => 'Small',
            ], 'default'),
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('show_description', 'Description', 'checkbox', [], true),
        ];

        return new ComponentPlaybook(
            slug: 'field',
            title: 'Field',
            description: 'Composable field shell with label, control, description, and errors.',
            controls: $controls,
            defaultState: [
                'orientation' => 'block',
                'size' => 'default',
                'invalid' => false,
                'show_description' => true,
            ],
            previewView: 'workbench::playbook.previews.field',
        );
    }

    private function textarea(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('size', 'Size', 'select', [
                'default' => 'Default',
                'sm' => 'Small',
            ], 'default'),
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
        ];

        return new ComponentPlaybook(
            slug: 'textarea',
            title: 'Textarea',
            description: 'Multi-line text control with validation and disabled states.',
            controls: $controls,
            defaultState: [
                'size' => 'default',
                'invalid' => false,
                'disabled' => false,
            ],
            previewView: 'workbench::playbook.previews.textarea',
        );
    }

    private function checkbox(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('size', 'Size', 'select', [
                'default' => 'Default',
                'sm' => 'Small',
            ], 'default'),
            new PlaybookControl('checked', 'Checked', 'checkbox', [], true),
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
        ];

        return new ComponentPlaybook(
            slug: 'checkbox',
            title: 'Checkbox',
            description: 'Native checkbox with Stencil choice-control styling.',
            controls: $controls,
            defaultState: [
                'size' => 'default',
                'checked' => true,
                'invalid' => false,
                'disabled' => false,
            ],
            previewView: 'workbench::playbook.previews.checkbox',
        );
    }

    private function radio(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('size', 'Size', 'select', [
                'default' => 'Default',
                'sm' => 'Small',
            ], 'default'),
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
        ];

        return new ComponentPlaybook(
            slug: 'radio',
            title: 'Radio',
            description: 'Radio group and items for single-choice fields.',
            controls: $controls,
            defaultState: [
                'size' => 'default',
                'invalid' => false,
            ],
            previewView: 'workbench::playbook.previews.radio',
        );
    }

    private function switch(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('size', 'Size', 'select', [
                'default' => 'Default',
                'sm' => 'Small',
            ], 'default'),
            new PlaybookControl('checked', 'Checked', 'checkbox', [], true),
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
        ];

        return new ComponentPlaybook(
            slug: 'switch',
            title: 'Switch',
            description: 'Binary toggle using role="switch" for settings-style controls.',
            controls: $controls,
            defaultState: [
                'size' => 'default',
                'checked' => true,
                'invalid' => false,
                'disabled' => false,
            ],
            previewView: 'workbench::playbook.previews.switch',
        );
    }

    private function dialog(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('size', 'Size', 'select', [
                'default' => 'Default',
                'sm' => 'Small',
            ], 'default'),
            new PlaybookControl('flyout', 'Flyout', 'checkbox', [], false),
            new PlaybookControl('alert', 'Alert dialog', 'checkbox', [], false),
            new PlaybookControl('dismissible', 'Dismissible', 'checkbox', [], true),
            new PlaybookControl('closable', 'Close button', 'checkbox', [], true),
        ];

        return new ComponentPlaybook(
            slug: 'dialog',
            title: 'Dialog',
            description: 'Modal layer with compound sub-components. Requires dialog.js in the app entry.',
            controls: $controls,
            defaultState: [
                'size' => 'default',
                'flyout' => false,
                'alert' => false,
                'dismissible' => true,
                'closable' => true,
            ],
            previewView: 'workbench::playbook.previews.dialog',
            wide: true,
        );
    }

    private function command(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'command',
            title: 'Command',
            description: 'Command palette with typeahead filtering and optional ⌘K dialog. Requires command.js and dialog.js.',
            controls: [],
            defaultState: [],
            previewView: 'workbench::playbook.previews.command',
            wide: true,
        );
    }

    private function accordion(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'accordion',
            title: 'Accordion',
            description: 'Vertically stacked disclosures with exclusive or multiple open items. Requires accordion.js in the app entry.',
            controls: [
                new PlaybookControl('exclusive', 'Exclusive (one open)', 'checkbox', [], true),
                new PlaybookControl('bordered', 'Bordered', 'checkbox', [], true),
                new PlaybookControl('transition', 'Animate height', 'checkbox', [], true),
            ],
            defaultState: [
                'exclusive' => true,
                'bordered' => true,
                'transition' => true,
            ],
            previewView: 'workbench::playbook.previews.accordion',
            wide: true,
        );
    }

    private function collapsible(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'collapsible',
            title: 'Collapsible',
            description: 'Single-panel expand and collapse. Requires collapsible.js in the app entry.',
            controls: [
                new PlaybookControl('open', 'Initially open', 'checkbox', [], true),
                new PlaybookControl('transition', 'Animate height', 'checkbox', [], true),
            ],
            defaultState: [
                'open' => true,
                'transition' => true,
            ],
            previewView: 'workbench::playbook.previews.collapsible',
        );
    }

    private function sidebar(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'sidebar',
            title: 'Sidebar',
            description: 'App-shell navigation with collapse modes and mobile overlay. Requires sidebar.js in the app entry.',
            controls: [
                new PlaybookControl('collapsible', 'Collapsible', 'select', [
                    'icon' => 'Icon',
                    'offcanvas' => 'Offcanvas',
                    'none' => 'None',
                ], 'icon'),
                new PlaybookControl('variant', 'Variant', 'select', [
                    'sidebar' => 'Sidebar',
                    'floating' => 'Floating',
                    'inset' => 'Inset',
                ], 'sidebar'),
                new PlaybookControl('default_open', 'Default open', 'checkbox', [], true),
            ],
            defaultState: [
                'collapsible' => 'icon',
                'variant' => 'sidebar',
                'default_open' => true,
            ],
            previewView: 'workbench::playbook.previews.sidebar',
            wide: true,
        );
    }

    private function avatar(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'avatar',
            title: 'Avatar',
            description: 'User image or initials, including stacked groups. Requires avatar.js for image-error fallback.',
            controls: [
                new PlaybookControl('size', 'Size', 'select', [
                    'xs' => 'Extra small',
                    'sm' => 'Small',
                    'default' => 'Default',
                    'lg' => 'Large',
                    'xl' => 'Extra large',
                ], 'default'),
                new PlaybookControl('color', 'Color', 'select', [
                    'violet' => 'Violet',
                    'blue' => 'Blue',
                    'green' => 'Green',
                    'amber' => 'Amber',
                    'rose' => 'Rose',
                ], 'violet'),
                new PlaybookControl('circle', 'Circle', 'checkbox', [], true),
                new PlaybookControl('show_group', 'Show group', 'checkbox', [], false),
            ],
            defaultState: [
                'size' => 'default',
                'color' => 'violet',
                'circle' => true,
                'show_group' => false,
            ],
            previewView: 'workbench::playbook.previews.avatar',
        );
    }

    private function badge(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'badge',
            title: 'Badge',
            description: 'Compact status labels with variants, colors, and optional dismiss.',
            controls: [
                new PlaybookControl('variant', 'Variant', 'select', [
                    'secondary' => 'Secondary',
                    'default' => 'Default',
                    'outline' => 'Outline',
                    'destructive' => 'Destructive',
                    'ghost' => 'Ghost',
                ], 'secondary'),
                new PlaybookControl('color', 'Color', 'select', [
                    '' => 'None',
                    'lime' => 'Lime',
                    'violet' => 'Violet',
                    'blue' => 'Blue',
                    'green' => 'Green',
                    'amber' => 'Amber',
                ], ''),
                new PlaybookControl('rounded', 'Rounded', 'checkbox', [], false),
                new PlaybookControl('dismissible', 'Dismissible', 'checkbox', [], false),
            ],
            defaultState: [
                'variant' => 'secondary',
                'color' => '',
                'rounded' => false,
                'dismissible' => false,
            ],
            previewView: 'workbench::playbook.previews.badge',
        );
    }

    private function breadcrumb(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'breadcrumb',
            title: 'Breadcrumb',
            description: 'Navigation trail for nested pages with chevron or slash separators.',
            controls: [
                new PlaybookControl('separator', 'Separator', 'select', [
                    'chevron' => 'Chevron',
                    'slash' => 'Slash',
                ], 'chevron'),
            ],
            defaultState: [
                'separator' => 'chevron',
            ],
            previewView: 'workbench::playbook.previews.breadcrumb',
            wide: true,
        );
    }

    private function card(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'card',
            title: 'Card',
            description: 'Content container with header, body, and footer slots.',
            controls: [
                new PlaybookControl('show_footer', 'Footer actions', 'checkbox', [], true),
            ],
            defaultState: [
                'show_footer' => true,
            ],
            previewView: 'workbench::playbook.previews.card',
            wide: true,
        );
    }

    private function stat(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'stat',
            title: 'Stat',
            description: 'Dashboard KPI card with label, value, trend, and optional icon.',
            controls: [
                new PlaybookControl('variant', 'Variant', 'select', [
                    'default' => 'Default',
                    'outline' => 'Outline',
                    'muted' => 'Muted',
                ], 'default'),
                new PlaybookControl('trend_direction', 'Trend', 'select', [
                    'up' => 'Up',
                    'down' => 'Down',
                    'neutral' => 'Neutral',
                ], 'up'),
                new PlaybookControl('show_icon', 'Icon', 'checkbox', [], true),
            ],
            defaultState: [
                'variant' => 'default',
                'trend_direction' => 'up',
                'show_icon' => true,
            ],
            previewView: 'workbench::playbook.previews.stat',
            wide: true,
        );
    }

    private function dropdownMenu(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'dropdown-menu',
            title: 'Dropdown Menu',
            description: 'Accessible action menu with labels, shortcuts, and danger items. Requires dropdown-menu.js.',
            controls: [
                new PlaybookControl('align', 'Align', 'select', [
                    'start' => 'Start',
                    'center' => 'Center',
                    'end' => 'End',
                ], 'start'),
            ],
            defaultState: [
                'align' => 'start',
            ],
            previewView: 'workbench::playbook.previews.dropdown-menu',
            wide: true,
        );
    }

    private function popover(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'popover',
            title: 'Popover',
            description: 'Anchored floating panel with trigger, Escape/outside dismiss, and focus management. Requires popover.js.',
            controls: [
                new PlaybookControl('align', 'Align', 'select', [
                    'start' => 'Start',
                    'center' => 'Center',
                    'end' => 'End',
                ], 'start'),
                new PlaybookControl('side', 'Side', 'select', [
                    'bottom' => 'Bottom',
                    'top' => 'Top',
                    'left' => 'Left',
                    'right' => 'Right',
                ], 'bottom'),
            ],
            defaultState: [
                'align' => 'start',
                'side' => 'bottom',
            ],
            previewView: 'workbench::playbook.previews.popover',
        );
    }

    private function separator(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'separator',
            title: 'Separator',
            description: 'Horizontal or vertical divider between content.',
            controls: [
                new PlaybookControl('orientation', 'Orientation', 'select', [
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                ], 'horizontal'),
            ],
            defaultState: [
                'orientation' => 'horizontal',
            ],
            previewView: 'workbench::playbook.previews.separator',
        );
    }

    private function skeleton(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'skeleton',
            title: 'Skeleton',
            description: 'Loading placeholders for content that is still arriving.',
            controls: [
                new PlaybookControl('rounded', 'Rounded', 'select', [
                    'default' => 'Default',
                    'full' => 'Full (circle)',
                ], 'default'),
            ],
            defaultState: [
                'rounded' => 'default',
            ],
            previewView: 'workbench::playbook.previews.skeleton',
        );
    }

    private function empty(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'empty',
            title: 'Empty',
            description: 'Composable empty state with media, title, description, and actions.',
            controls: [
                new PlaybookControl('show_icon', 'Icon media', 'checkbox', [], true),
                new PlaybookControl('outline', 'Outline border', 'checkbox', [], true),
                new PlaybookControl('show_actions', 'Actions', 'checkbox', [], true),
            ],
            defaultState: [
                'show_icon' => true,
                'outline' => true,
                'show_actions' => true,
            ],
            previewView: 'workbench::playbook.previews.empty',
            wide: true,
        );
    }

    private function tabs(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'tabs',
            title: 'Tabs',
            description: 'Tabbed panels with default, segmented, pills, and line variants. Requires tabs.js.',
            controls: [
                new PlaybookControl('variant', 'Variant', 'select', [
                    'default' => 'Default',
                    'line' => 'Line',
                    'pills' => 'Pills',
                    'segmented' => 'Segmented',
                ], 'default'),
            ],
            defaultState: [
                'variant' => 'default',
            ],
            previewView: 'workbench::playbook.previews.tabs',
            wide: true,
        );
    }

    private function stepper(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'stepper',
            title: 'Stepper',
            description: 'Multi-step wizard indicator with panels and previous/next controls. Requires stepper.js.',
            controls: [
                new PlaybookControl('orientation', 'Orientation', 'select', [
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                ], 'horizontal'),
                new PlaybookControl('linear', 'Linear (block skipping ahead)', 'checkbox', [], true),
            ],
            defaultState: [
                'orientation' => 'horizontal',
                'linear' => true,
            ],
            previewView: 'workbench::playbook.previews.stepper',
            wide: true,
        );
    }

    private function tooltip(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'tooltip',
            title: 'Tooltip',
            description: 'Hover and focus hints for controls. Requires tooltip.js in the app entry.',
            controls: [
                new PlaybookControl('side', 'Side', 'select', [
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right',
                ], 'top'),
            ],
            defaultState: [
                'side' => 'top',
            ],
            previewView: 'workbench::playbook.previews.tooltip',
        );
    }

    private function toast(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'toast',
            title: 'Toast',
            description: 'Transient notifications. Mount toast.provider once, then render toasts. Requires toast.js.',
            controls: [
                new PlaybookControl('variant', 'Variant', 'select', [
                    'default' => 'Default',
                    'success' => 'Success',
                    'warning' => 'Warning',
                    'danger' => 'Danger',
                ], 'success'),
                new PlaybookControl('position', 'Position (relative stage)', 'select', [
                    'bottom-right' => 'Bottom right',
                    'bottom-left' => 'Bottom left',
                    'top-right' => 'Top right',
                    'top-center' => 'Top center',
                ], 'bottom-right'),
            ],
            defaultState: [
                'variant' => 'success',
                'position' => 'bottom-right',
            ],
            previewView: 'workbench::playbook.previews.toast',
            wide: true,
        );
    }

    private function progress(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'progress',
            title: 'Progress',
            description: 'Determinate and indeterminate progress bars.',
            controls: [
                new PlaybookControl('value', 'Value', 'select', [
                    '25' => '25%',
                    '40' => '40%',
                    '75' => '75%',
                ], '40'),
                new PlaybookControl('size', 'Size', 'select', [
                    'default' => 'Default',
                    'sm' => 'Small',
                    'lg' => 'Large',
                ], 'default'),
                new PlaybookControl('indeterminate', 'Indeterminate', 'checkbox', [], false),
            ],
            defaultState: [
                'value' => '40',
                'size' => 'default',
                'indeterminate' => false,
            ],
            previewView: 'workbench::playbook.previews.progress',
        );
    }

    private function alert(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'alert',
            title: 'Alert',
            description: 'Inline callouts for info, success, warning, and danger.',
            controls: [
                new PlaybookControl('variant', 'Variant', 'select', [
                    'default' => 'Default',
                    'info' => 'Info',
                    'success' => 'Success',
                    'warning' => 'Warning',
                    'danger' => 'Danger',
                ], 'info'),
                new PlaybookControl('show_icon', 'Icon', 'checkbox', [], true),
            ],
            defaultState: [
                'variant' => 'info',
                'show_icon' => true,
            ],
            previewView: 'workbench::playbook.previews.alert',
        );
    }

    private function table(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'table',
            title: 'Table',
            description: 'Semantic data table with caption, header, body, and footer.',
            controls: [
                new PlaybookControl('show_caption', 'Caption', 'checkbox', [], true),
                new PlaybookControl('show_badges', 'Status badges', 'checkbox', [], true),
            ],
            defaultState: [
                'show_caption' => true,
                'show_badges' => true,
            ],
            previewView: 'workbench::playbook.previews.table',
            wide: true,
        );
    }

    private function icons(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'icons',
            title: 'Icons',
            description: 'On-demand Lucide icons — outline, mini, and micro sizes via stencil:icon.',
            controls: [
                new PlaybookControl('size', 'Size', 'select', [
                    'micro' => 'Micro (12px)',
                    'outline' => 'Outline (16px)',
                    'mini' => 'Mini (20px)',
                ], 'outline'),
            ],
            defaultState: [
                'size' => 'outline',
            ],
            previewView: 'workbench::playbook.previews.icons',
            wide: true,
        );
    }

    private function pagination(): ComponentPlaybook
    {
        return new ComponentPlaybook(
            slug: 'pagination',
            title: 'Pagination',
            description: 'Page controls for lists and tables. Compose manually or pass a Laravel paginator.',
            controls: [
                new PlaybookControl('show_ellipsis', 'Ellipsis', 'checkbox', [], true),
            ],
            defaultState: [
                'show_ellipsis' => true,
            ],
            previewView: 'workbench::playbook.previews.pagination',
            wide: true,
        );
    }

    private function calendar(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('mode', 'Mode', 'select', [
                'single' => 'Single',
                'range' => 'Range',
            ], 'single'),
            new PlaybookControl('withToday', 'Today shortcut', 'checkbox', [], true),
            new PlaybookControl('weekNumbers', 'Week numbers', 'checkbox', [], false),
        ];

        return new ComponentPlaybook(
            slug: 'calendar',
            title: 'Calendar',
            description: 'Standalone month grid for single or range dates. Requires calendar.js in the app entry.',
            controls: $controls,
            defaultState: [
                'mode' => 'single',
                'withToday' => true,
                'weekNumbers' => false,
            ],
            previewView: 'workbench::playbook.previews.calendar',
            wide: true,
        );
    }

    private function datePicker(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('mode', 'Mode', 'select', [
                'single' => 'Single',
                'range' => 'Range',
            ], 'single'),
            new PlaybookControl('withPresets', 'Presets', 'checkbox', [], false),
            new PlaybookControl('withToday', 'Today shortcut', 'checkbox', [], true),
        ];

        return new ComponentPlaybook(
            slug: 'date-picker',
            title: 'Date Picker',
            description: 'Date and range selection with calendar overlay. Requires date-picker.js in the app entry.',
            controls: $controls,
            defaultState: [
                'mode' => 'single',
                'withPresets' => false,
                'withToday' => true,
            ],
            previewView: 'workbench::playbook.previews.date-picker',
            wide: true,
        );
    }

    private function timePicker(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('withSeconds', 'With seconds', 'checkbox', [], false),
            new PlaybookControl('clearable', 'Clearable', 'checkbox', [], true),
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
        ];

        return new ComponentPlaybook(
            slug: 'time-picker',
            title: 'Time Picker',
            description: 'Time selection list with optional seconds. Requires time-picker.js in the app entry.',
            controls: $controls,
            defaultState: [
                'withSeconds' => false,
                'clearable' => true,
                'invalid' => false,
                'disabled' => false,
            ],
            previewView: 'workbench::playbook.previews.time-picker',
        );
    }

    private function datetimePicker(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('withToday', 'Today shortcut', 'checkbox', [], true),
            new PlaybookControl('clearable', 'Clearable', 'checkbox', [], false),
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
        ];

        return new ComponentPlaybook(
            slug: 'datetime-picker',
            title: 'Datetime Picker',
            description: 'Combined date and time panel. Requires datetime-picker.js in the app entry.',
            controls: $controls,
            defaultState: [
                'withToday' => true,
                'clearable' => false,
                'invalid' => false,
                'disabled' => false,
            ],
            previewView: 'workbench::playbook.previews.datetime-picker',
            wide: true,
        );
    }
}
