<!DOCTYPE html>
<html
    lang="en"
    class="antialiased {{ ($dark ?? false) ? 'dark' : '' }}"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Stencil Media')</title>
    <x-stencil::fonts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: fit-content;
            max-width: 100%;
            background: transparent;
        }

        #readme-media {
            box-sizing: border-box;
            width: max-content;
            max-width: min(56rem, 100vw);
            padding-block: 1rem;
            padding-inline: 0;
            background: transparent;
        }
    </style>
</head>
<body class="text-zinc-900 dark:text-zinc-50">
    <div id="readme-media" class="w-full">
        @yield('content')
    </div>
</body>
</html>
