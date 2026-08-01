@props([
    'commandId' => null,
    'listboxId' => null,
    'empty' => null,
    'placeholder' => null,
    'shortcut' => true,
])

@php
    $commandId = filled($commandId)
        ? $commandId
        : 'command-'.str_replace('.', '', uniqid('', true));
    $listboxId = filled($listboxId) ? $listboxId : $commandId.'-listbox';

    $emptyMessage = filled($empty)
        ? (string) $empty
        : __('stencil::messages.command_empty');

    $rootAttributes = $attributes
        ->except('shortcut')
        ->class([
            'command',
            'flex w-full flex-col overflow-hidden rounded-xl bg-white text-zinc-950',
            'dark:bg-zinc-950 dark:text-zinc-50',
        ])
        ->merge([
            'data-command' => true,
            'data-command-id' => $commandId,
            'data-command-listbox-id' => $listboxId,
        ]);
@endphp

<div {{ $rootAttributes }}>
    @if ($shortcut)
        <x-stencil::command.input :placeholder="$placeholder" />
        <x-stencil::command.list>
            <x-stencil::command.empty>{{ $emptyMessage }}</x-stencil::command.empty>
            {{ $slot }}
        </x-stencil::command.list>
    @else
        {{ $slot }}
    @endif
</div>
