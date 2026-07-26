<?php

declare(strict_types=1);

namespace Workbench\App\Playbook;

use Illuminate\Validation\ValidationException;

final class PlaybookStateValidator
{
    /**
     * @param  array<string, mixed>  $state
     * @return array<string, mixed>
     */
    public function validate(ComponentPlaybook $playbook, array $state): array
    {
        $validated = [];

        foreach ($playbook->controls as $control) {
            $value = array_key_exists($control->key, $state)
                ? $state[$control->key]
                : $playbook->defaultState[$control->key] ?? $control->default;

            $validated[$control->key] = $this->castControlValue($control, $value);
        }

        $unknown = array_diff(array_keys($state), $playbook->controlKeys());

        if ($unknown !== []) {
            throw ValidationException::withMessages([
                'state' => 'Unknown control keys: '.implode(', ', $unknown),
            ]);
        }

        return $validated;
    }

    private function castControlValue(PlaybookControl $control, mixed $value): mixed
    {
        return match ($control->type) {
            'checkbox' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'select' => $this->castSelectValue($control, $value),
            'text' => is_string($value) ? $value : (string) $value,
            default => throw ValidationException::withMessages([
                $control->key => "Unsupported control type [{$control->type}].",
            ]),
        };
    }

    private function castSelectValue(PlaybookControl $control, mixed $value): string
    {
        $stringValue = is_string($value) ? $value : (string) $value;

        if (! array_key_exists($stringValue, $control->options)) {
            throw ValidationException::withMessages([
                $control->key => "The selected value [{$stringValue}] is invalid.",
            ]);
        }

        return $stringValue;
    }
}
