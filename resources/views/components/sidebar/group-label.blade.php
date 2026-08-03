@if ($asChild)
    <div {{ $attributes->class([...$classes, 'contents'])->merge(['data-sidebar-group-label' => true]) }}>
        {{ $slot }}
    </div>
@else
    <div {{ $attributes->class($classes)->merge(['data-sidebar-group-label' => true]) }}>{{ $slot }}</div>
@endif
