@props([
    'value' => null,
    'disabled' => false,
    'href' => null,
    'kbd' => null,
    'icon' => null,
    'keepOpen' => false,
])

@aware([
    'commandId' => null,
])

@php
    $isDisabled = (bool) $disabled;
    $useLink = filled($href);
    $tag = $useLink ? 'a' : 'button';

    $resolvedCommandId = filled($commandId) ? $commandId : null;
    $optionId = filled($resolvedCommandId) && filled($value)
        ? $resolvedCommandId.'-option-'.preg_replace('/[^a-zA-Z0-9_-]/', '-', (string) $value)
        : null;

    $keywords = filled($value) ? (string) $value : '';

    $itemAttributes = $attributes
        ->except(['value', 'disabled', 'href', 'kbd', 'icon', 'keepOpen'])
        ->class([
            'command__item',
            'relative flex w-full cursor-default items-center gap-2 rounded-md px-2 py-1.5 text-sm outline-none select-none',
            'text-zinc-950 dark:text-zinc-50',
            'hover:bg-zinc-100 data-[highlighted]:bg-zinc-100 dark:hover:bg-zinc-800 dark:data-[highlighted]:bg-zinc-800',
            '[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=size-])]:size-4',
            '[&_svg:not([class*=text-])]:text-zinc-500 dark:[&_svg:not([class*=text-])]:text-zinc-400',
            $isDisabled ? 'pointer-events-none opacity-50' : null,
        ])
        ->merge([
            'type' => $useLink ? null : 'button',
            'href' => $useLink ? $href : null,
            'role' => 'option',
            'tabindex' => '-1',
            'data-command-item' => true,
            'data-value' => filled($value) ? $value : null,
            'data-keywords' => $keywords !== '' ? $keywords : null,
            'data-keep-open' => $keepOpen ? 'true' : null,
            'data-disabled' => $isDisabled ? 'true' : null,
            'aria-disabled' => $isDisabled ? 'true' : null,
            'aria-selected' => 'false',
            'disabled' => (! $useLink && $isDisabled) ? true : null,
        ]);

    if (filled($optionId)) {
        $itemAttributes = $itemAttributes->merge(['id' => $optionId]);
    }
@endphp

<{{ $tag }} {{ $itemAttributes }}>
    @if (filled($icon))
        <x-stencil::icon :name="$icon" class="size-4 shrink-0 text-zinc-500 dark:text-zinc-400" />
    @endif
    <span class="min-w-0 flex-1 truncate text-left" data-command-item-label>{{ $slot }}</span>
    @if (filled($kbd))
        <x-stencil::command.shortcut>{{ $kbd }}</x-stencil::command.shortcut>
    @endif
</{{ $tag }}>
