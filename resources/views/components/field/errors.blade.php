@props([
    'name',
])

@error($name)
    <x-stencil::field.message variant="error">{{ $message }}</x-stencil::field.message>
@enderror
