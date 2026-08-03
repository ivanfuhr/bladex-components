@if ($asChild)
    <div {{
        $attributes->class([...array_filter($classes), 'contents'])->merge([
            'data-sidebar-menu-action' => true,
            'data-sidebar' => 'menu-action',
        ])
    }}>
        {{ $slot }}
    </div>
@else
    <button
        type="button"
        {{
            $attributes->class(array_filter($classes))->merge([
                'data-sidebar-menu-action' => true,
                'data-sidebar' => 'menu-action',
            ])
        }}
    >
        {{ $slot }}
    </button>
@endif
