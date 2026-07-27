<?php

declare(strict_types=1);

return [
    'lucide_raw_url' => 'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/{name}.svg',

    'typography' => json_decode(<<<'JSON'
{
    "scale": {
        "sm": {
            "text": "text-sm",
            "leading": "leading-5"
        },
        "default": {
            "text": "text-base",
            "leading": "leading-6"
        },
        "lg": {
            "text": "text-lg",
            "leading": "leading-7"
        },
        "xl": {
            "text": "text-xl",
            "leading": "leading-8"
        }
    },
    "fonts": {
        "sans": {
            "provider": "google",
            "family": "Inter",
            "weights": [
                400,
                500,
                600,
                700
            ],
            "subsets": [
                "latin"
            ],
            "fallback": "ui-sans-serif, system-ui, sans-serif"
        }
    },
    "roles": {
        "body": "sans",
        "heading": "sans"
    },
    "defaults": {
        "text_size": "default",
        "heading_level": 2
    }
}
JSON, true),
];
