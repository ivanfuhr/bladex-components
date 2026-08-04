@if ($asChild)
    <div {{
        $attributes->class([...$classes, 'contents'])->merge([
            'data-sidebar-menu-button' => true,
            'data-size' => $size,
            'data-active' => $isActive ? 'true' : 'false',
        ])
    }}>
        {{ $slot }}
    </div>
@elseif ($hasTooltip)
    {{-- display:contents keeps menu-button a layout sibling of badge/action for absolute positioning --}}
    <x-ui::tooltip side="right" class="contents!" data-sidebar-menu-tooltip>
        <x-ui::tooltip.trigger class="contents!">
            <{{ $tag }}
                {{
                    $attributes->class($classes)->merge([
                        'type' => $useLink ? null : 'button',
                        'href' => $useLink ? $href : null,
                        'data-sidebar-menu-button' => true,
                        'data-sidebar' => 'menu-button',
                        'data-size' => $size,
                        'data-active' => $isActive ? 'true' : 'false',
                        'aria-current' => ($isActive && $useLink) ? 'page' : null,
                    ])
                }}
            >
                {{ $slot }}
            </{{ $tag }}>
        </x-ui::tooltip.trigger>
        <x-ui::tooltip.content side="right"> {{ $tooltip }} </x-ui::tooltip.content>
    </x-ui::tooltip>
@else
    <{{ $tag }}
        {{
            $attributes->class($classes)->merge([
                'type' => $useLink ? null : 'button',
                'href' => $useLink ? $href : null,
                'data-sidebar-menu-button' => true,
                'data-sidebar' => 'menu-button',
                'data-size' => $size,
                'data-active' => $isActive ? 'true' : 'false',
                'aria-current' => ($isActive && $useLink) ? 'page' : null,
            ])
        }}
    >
        {{ $slot }}
    </{{ $tag }}>
@endif
