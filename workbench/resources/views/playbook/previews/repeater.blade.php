@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $min = max(0, (int) ($state['min'] ?? 1));
    $max = filled($state['max'] ?? null) ? max($min, (int) $state['max']) : null;

    $value = [
        ['name' => 'Ada Lovelace', 'role' => 'Owner'],
        ['name' => 'Alan Turing', 'role' => 'Member'],
    ];
@endphp

<x-ui::repeater
    name="members"
    :value="$value"
    :min="$min"
    :max="$max"
    :invalid="$invalid"
    :disabled="$disabled"
    class="w-full max-w-xl"
>
    <x-ui::repeater.item>
        <div class="grid gap-3 sm:grid-cols-2">
            <x-ui::input data-repeater-field="name" placeholder="Name" />
            <x-ui::input data-repeater-field="role" placeholder="Role" />
        </div>
        <x-ui::repeater.remove />
    </x-ui::repeater.item>

    <x-ui::repeater.add>Add member</x-ui::repeater.add>
</x-ui::repeater>
