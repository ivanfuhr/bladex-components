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
            $this->select(),
            $this->text(),
            $this->heading(),
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

    private function select(): ComponentPlaybook
    {
        $controls = [
            new PlaybookControl('invalid', 'Invalid', 'checkbox', [], false),
            new PlaybookControl('disabled', 'Disabled', 'checkbox', [], false),
            new PlaybookControl('size', 'Size', 'select', [
                'default' => 'Default',
                'sm' => 'Small',
            ], 'default'),
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
                'size' => 'default',
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
}
