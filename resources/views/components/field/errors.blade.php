<div {{ $wrapperAttributes }}>
    @if (str_contains($name, '*'))
        @foreach ($errors->getBag('default')->getMessages() as $key => $bagMessages)
            @if (\Illuminate\Support\Str::is($name, $key))
                @foreach ($bagMessages as $message)
                    <x-ui::field.message variant="error">{{ $message }}</x-ui::field.message>
                @endforeach
            @endif
        @endforeach
    @else
        @error($name)
            <x-ui::field.message variant="error">{{ $message }}</x-ui::field.message>
        @enderror
    @endif
</div>
