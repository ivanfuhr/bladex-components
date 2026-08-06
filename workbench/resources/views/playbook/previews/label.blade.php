@php
    $badge = $state['badge'] ?? '';
    $required = (bool) ($state['required'] ?? false);
@endphp

<x-std::label for="email" :badge="$badge !== '' ? $badge : null" :required="$required"> Email address </x-std::label>
