@aware([
    'orientation' => 'horizontal',
])

@php
    $explicit = $attributes->get('orientation');

    if (filled($explicit)) {
        $separatorOrientation = $explicit === 'horizontal' ? 'horizontal' : 'vertical';
        $attributes = $attributes->except('orientation');
    } else {
        $parentOrientation = $orientation === 'vertical' ? 'vertical' : 'horizontal';
        $separatorOrientation = $parentOrientation === 'vertical' ? 'horizontal' : 'vertical';
    }
@endphp

<div
    {{
        $attributes->class([
            'button-group__separator',
            'separator relative m-0 shrink-0 self-stretch bg-zinc-200 dark:bg-zinc-800',
            $separatorOrientation === 'vertical' ? 'h-auto w-px' : 'h-px w-auto',
        ])->merge([
            'data-button-group-separator' => true,
            'data-separator' => true,
            'data-orientation' => $separatorOrientation,
            'role' => 'none',
        ])
    }}
></div>
