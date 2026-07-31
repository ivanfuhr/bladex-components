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

<x-stencil::repeater
    name="members"
    :value="$value"
    :min="$min"
    :max="$max"
    :invalid="$invalid"
    :disabled="$disabled"
    class="w-full max-w-xl"
>
    <x-stencil::repeater.item>
        <div class="grid gap-3 sm:grid-cols-2">
            <x-stencil::input data-repeater-field="name" placeholder="Name" />
            <x-stencil::input data-repeater-field="role" placeholder="Role" />
        </div>
        <x-stencil::repeater.remove />
    </x-stencil::repeater.item>

    <x-stencil::repeater.add>Add member</x-stencil::repeater.add>
</x-stencil::repeater>
