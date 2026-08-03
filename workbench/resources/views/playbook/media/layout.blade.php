<!DOCTYPE html>
<html lang="en" class="antialiased {{ ($dark ?? false) ? 'dark scheme-dark' : 'scheme-light' }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Stencil Media')</title>
    <x-ui::fonts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /*
         * Fixed width for README screenshots: every capture shares the same
         * canvas width; height follows content. Keep in sync with README layout.
         */
        :root {
            --readme-media-width: 56rem;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: var(--readme-media-width);
            background: transparent;
        }

        #readme-media {
            box-sizing: border-box;
            width: var(--readme-media-width);
            padding-block: 1rem;
            padding-inline: 0;
            background: transparent;
        }
    </style>
</head>
<body class="text-zinc-900 dark:text-zinc-50">
    <main id="readme-media" class="w-full">
        @yield('content')
    </main>
</body>
</html>
