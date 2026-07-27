<?php

declare(strict_types=1);

namespace App\Support\Stencil\Typography;

final class GoogleFontsStylesheetBuilder
{
    public function __construct(
        private readonly TypographyConfig $typographyConfig,
    ) {}

    public function buildUrl(): ?string
    {
        $definitions = $this->typographyConfig->googleFontDefinitions();

        if ($definitions === []) {
            return null;
        }

        $families = [];

        foreach ($definitions as $definition) {
            $weights = $definition['weights'] !== [] ? $definition['weights'] : [400];
            sort($weights);
            $weightList = implode(';', array_map(strval(...), $weights));
            $family = str_replace(' ', '+', $definition['family']);
            $families[] = "family={$family}:wght@{$weightList}";
        }

        $query = implode('&', $families);
        $query .= '&display=swap';

        return 'https://fonts.googleapis.com/css2?'.$query;
    }
}
