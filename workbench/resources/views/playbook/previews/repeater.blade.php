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

<x-std::repeater
    name="members"
    :value="$value"
    :min="$min"
    :max="$max"
    :invalid="$invalid"
    :disabled="$disabled"
    class="w-full max-w-xl"
>
    <x-std::repeater.item>
        <div class="grid gap-3 sm:grid-cols-2">
            <x-std::input data-repeater-field="name" placeholder="Name" />
            <x-std::input data-repeater-field="role" placeholder="Role" />
        </div>
        <x-std::repeater.remove />
    </x-std::repeater.item>

    <x-std::repeater.add>Add member</x-std::repeater.add>
</x-std::repeater>
