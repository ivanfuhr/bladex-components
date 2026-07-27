<!DOCTYPE html>
<html
    lang="en"
    class="antialiased {{ ($dark ?? false) ? 'dark' : '' }}"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BladeX Media')</title>
    <x-bladex-components::fonts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body { margin: 0; padding: 0; }
        #readme-media { box-sizing: border-box; padding: 2rem 2.5rem; }
    </style>
</head>
<body class="bg-white text-zinc-900 dark:bg-zinc-950 dark:text-zinc-50">
    <div id="readme-media" class="w-full">
        @yield('content')
    </div>
</body>
</html>
