<span {{ $attributes->class($chipClasses)->merge(['data-select-chip' => true]) }}>
    <span class="min-w-0 truncate" data-select-chip-label>{{ $slot }}</span>
</span>
