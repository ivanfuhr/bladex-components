@if ($stylesheetUrl !== null)
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="{{ $stylesheetUrl }}" />
@endif

@if ($cssVariables !== [])
    <style>
        :root {
            @foreach ($cssVariables as $key => $value)
            --font-{{ $key }}: {!! $value !!};
        @endforeach
        }
    </style>
@endif
