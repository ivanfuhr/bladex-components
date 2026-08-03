<x-ui::label :for="$resolvedFor" {{ $attributes->except('for') }}> {{ $slot }} </x-ui::label>
