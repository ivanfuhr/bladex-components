@props([
    'name',
])

@if (str_contains($name, '*'))
    @foreach ($errors->getBag('default')->getMessages() as $key => $bagMessages)
        @if (\Illuminate\Support\Str::is($name, $key))
            @foreach ($bagMessages as $message)
                <x-stencil::field.message variant="error">{{ $message }}</x-stencil::field.message>
            @endforeach
        @endif
    @endforeach
@else
    @error($name)
        <x-stencil::field.message variant="error">{{ $message }}</x-stencil::field.message>
    @enderror
@endif
