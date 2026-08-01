@aware([
    'commandId' => null,
    'listboxId' => null,
])

@props([
    'placeholder' => null,
    'commandId' => null,
    'listboxId' => null,
])

@php
    $resolvedPlaceholder = filled($placeholder)
        ? (string) $placeholder
        : __('stencil::messages.command_placeholder');

    $resolvedCommandId = filled($commandId) ? $commandId : null;
    $resolvedListboxId = filled($listboxId)
        ? $listboxId
        : (filled($resolvedCommandId) ? $resolvedCommandId.'-listbox' : null);
    $inputId = filled($resolvedCommandId) ? $resolvedCommandId.'-input' : null;

    $inputAttributes = $attributes
        ->except(['placeholder', 'commandId', 'listboxId'])
        ->class([
            'command__input',
            'flex h-11 w-full min-w-0 bg-transparent py-3 text-sm text-zinc-950 outline-none',
            'placeholder:text-zinc-500 disabled:cursor-not-allowed disabled:opacity-50',
            'dark:text-zinc-50 dark:placeholder:text-zinc-400',
        ])
        ->merge([
            'type' => 'text',
            'role' => 'combobox',
            'aria-autocomplete' => 'list',
            'aria-expanded' => 'true',
            'aria-haspopup' => 'listbox',
            'autocomplete' => 'off',
            'autocorrect' => 'off',
            'spellcheck' => 'false',
            'placeholder' => $resolvedPlaceholder,
            'data-command-input' => true,
            'data-dialog-initial-focus' => true,
        ]);

    if (filled($inputId)) {
        $inputAttributes = $inputAttributes->merge(['id' => $inputId]);
    }

    if (filled($resolvedListboxId)) {
        $inputAttributes = $inputAttributes->merge(['aria-controls' => $resolvedListboxId]);
    }
@endphp

<div
    class="command__input-wrap flex items-center gap-2 border-b border-zinc-200 px-3 dark:border-zinc-800"
    data-command-input-wrap
>
    <x-stencil::icon
        name="search"
        class="size-4 shrink-0 text-zinc-500 dark:text-zinc-400"
        data-command-search-icon
    />
    <input {{ $inputAttributes }} />
</div>
