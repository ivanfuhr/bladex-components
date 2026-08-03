@if ($inline)
    <span {{ $attributes->class($classes) }} data-text>{{ $slot }}</span>
@else
    <p {{ $attributes->class($classes) }} data-text>{{ $slot }}</p>
@endif
