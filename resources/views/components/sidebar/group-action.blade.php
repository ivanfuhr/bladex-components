@if ($asChild)
    <div {{ $attributes->class([...$classes, 'contents'])->merge(['data-sidebar-group-action' => true]) }}>
        {{ $slot }}
    </div>
@else
    <button type="button" {{ $attributes->class($classes)->merge(['data-sidebar-group-action' => true]) }}>
        {{ $slot }}
    </button>
@endif
