<fieldset {{ $groupAttributes }}>
    @if (filled($legend))
        <legend class="mb-1">
            <x-ui::text size="sm" class="font-medium text-zinc-950 dark:text-zinc-50">{{ $legend }}</x-ui::text>
        </legend>
    @endif

    {{ $slot }}
</fieldset>
