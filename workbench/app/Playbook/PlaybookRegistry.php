<?php

declare(strict_types=1);

namespace Workbench\App\Playbook;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PlaybookRegistry
{
    /** @var Collection<int, ComponentPlaybook>|null */
    private ?Collection $playbooks = null;

    /**
     * @return list<ComponentPlaybook>
     */
    public function all(): array
    {
        return $this->playbooks()->values()->all();
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
     * @return Collection<string, ComponentPlaybook>
     */
    private function playbooks(): Collection
    {
        if ($this->playbooks !== null) {
            return $this->playbooks;
        }

        $definitions = [
            $this->button(),
            $this->input(),
            $this->inputCurrency(),
            $this->select(),
            $this->label(),
            $this->field(),
            $this->textarea(),
            $this->checkbox(),
            $this->radio(),
            $this->switch(),
            $this->text(),
            $this->heading(),
            $this->dialog(),
            $this->datePicker(),
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
                'value' => 1234.56,
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
        );
    }
}
