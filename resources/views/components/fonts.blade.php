@php
    use Ivanfuhr\BladexComponents\Support\Typography\GoogleFontsStylesheetBuilder;
    use Ivanfuhr\BladexComponents\Support\Typography\TypographyConfig;

    $typographyConfig = app(TypographyConfig::class);
    $stylesheetUrl = app(GoogleFontsStylesheetBuilder::class)->buildUrl();
    $cssVariables = $typographyConfig->cssFontVariables();
@endphp

@if ($stylesheetUrl !== null)
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ $stylesheetUrl }}">
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
