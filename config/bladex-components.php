<?php

declare(strict_types=1);

return [

    'placeholder' => 'default',

    'project_config_file' => 'bladex-components.json',

    'project_lock_file' => 'bladex-components.lock',

    'default_ui_path' => 'resources/views/ui',

    'default_icons_path' => 'resources/views/ui/icons',

    'lucide_raw_url' => 'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/{name}.svg',

    'package_registry_path' => null,

    'default_registry_url' => 'package://registry.json',

    'default_schema_url' => 'https://raw.githubusercontent.com/ivanfuhr/bladex-components/main/registry/schema/bladex-components.json',

    /*
    | When APP_DEBUG is true, HTTP requests fail fast if Tailwind is not set up to
    | scan BladeX package sources (see resources/tailwind/bladex.css). Artisan and
    | unit tests are not checked. Override in the host app config or set
    | validate_tailwind_integration => false to disable.
    */
    'validate_tailwind_integration' => true,

    'typography' => [
        'scale' => [
            'sm' => ['text' => 'text-sm', 'leading' => 'leading-5'],
            'default' => ['text' => 'text-base', 'leading' => 'leading-6'],
            'lg' => ['text' => 'text-lg', 'leading' => 'leading-7'],
            'xl' => ['text' => 'text-xl', 'leading' => 'leading-8'],
        ],
        'fonts' => [
            'sans' => [
                'provider' => 'google',
                'family' => 'Inter',
                'weights' => [400, 500, 600, 700],
                'subsets' => ['latin'],
                'fallback' => 'ui-sans-serif, system-ui, sans-serif',
            ],
        ],
        'roles' => [
            'body' => 'sans',
            'heading' => 'sans',
        ],
        'defaults' => [
            'text_size' => 'default',
            'heading_level' => 2,
        ],
    ],

];
