@if ($asChild)
    <div {{
        $attributes->class([...$classes, 'contents'])->merge([
            'data-sidebar-menu-sub-button' => true,
            'data-size' => $size,
            'data-active' => $isActive ? 'true' : 'false',
        ])
    }}>
        {{ $slot }}
    </div>
@else
    <{{ $tag }}
        {{
            $attributes->class($classes)->merge([
                'type' => $useLink ? null : 'button',
                'href' => $useLink ? $href : null,
                'data-sidebar-menu-sub-button' => true,
                'data-size' => $size,
                'data-active' => $isActive ? 'true' : 'false',
                'aria-current' => ($isActive && $useLink) ? 'page' : null,
            ])
        }}
    >
        {{ $slot }}
    </{{ $tag }}>
@endif
