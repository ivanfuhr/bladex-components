<div {{ $wrapperAttributes }}>
    @if (str_contains($name, '*'))
        @foreach ($errors->getBag('default')->getMessages() as $key => $bagMessages)
            @if (\Illuminate\Support\Str::is($name, $key))
                @foreach ($bagMessages as $message)
                    <x-std::field.message variant="error">{{ $message }}</x-std::field.message>
                @endforeach
            @endif
        @endforeach
    @else
        @error($name)
            <x-std::field.message variant="error">{{ $message }}</x-std::field.message>
        @enderror
    @endif
</div>
