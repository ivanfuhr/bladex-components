@props([
    'name',
])

@error($name)
    <x-bladex-components::field.message variant="error">{{ $message }}</x-bladex-components::field.message>
@enderror
