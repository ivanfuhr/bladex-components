<fieldset {{ $groupAttributes }}>
    @if (filled($legend))
        <legend class="mb-1">
            <x-std::text size="sm" class="font-medium text-zinc-950 dark:text-zinc-50">{{ $legend }}</x-std::text>
        </legend>
    @endif

    {{ $slot }}
</fieldset>
