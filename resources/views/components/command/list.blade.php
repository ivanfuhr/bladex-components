@aware([
    'commandId' => null,
    'listboxId' => null,
])

@props([
    'listboxId' => null,
])

@php
    $resolvedCommandId = filled($commandId) ? $commandId : null;
    $resolvedListboxId = filled($listboxId)
        ? $listboxId
        : (filled($resolvedCommandId) ? $resolvedCommandId.'-listbox' : null);

    $listAttributes = $attributes
        ->except(['listboxId'])
        ->class([
            'command__list',
            'max-h-[min(300px,50vh)] scroll-py-1 overflow-x-hidden overflow-y-auto p-1',
        ])
        ->merge([
            'role' => 'listbox',
            'tabindex' => '-1',
            'data-command-list' => true,
        ]);

    if (filled($resolvedListboxId)) {
        $listAttributes = $listAttributes->merge(['id' => $resolvedListboxId]);
    }
@endphp

<div {{ $listAttributes }}>{{ $slot }}</div>
