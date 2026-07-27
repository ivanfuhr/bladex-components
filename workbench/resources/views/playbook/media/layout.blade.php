<!DOCTYPE html>
<html
    lang="en"
    class="h-full antialiased {{ ($dark ?? false) ? 'dark scheme-dark' : 'scheme-light' }}"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BladeX Media')</title>
    <x-bladex-components::fonts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-zinc-100/90 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-50">
    <div class="mx-auto max-w-5xl px-10 py-12">
        @yield('content')
    </div>
</body>
</html>
